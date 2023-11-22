<?php

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Fixture;

use Doctrine\Persistence\ManagerRegistry;

final class Fixture
{
    /** @var array<FixtureInterface> */
    private array $fixtures;

    private ManagerRegistry $managerRegistry;

    private FixtureReferenceRepository $fixtureReferenceRepository;

    public function __construct(ManagerRegistry $managerRegistry, FixtureReferenceRepository $fixtureReferenceRepository)
    {
        // init values
        $this->fixtures = [];
        $this->managerRegistry = $managerRegistry;
        $this->fixtureReferenceRepository = $fixtureReferenceRepository;
    }

    public function addFixture(FixtureInterface $fixture): void
    {
        $this->fixtures[] = $fixture;
    }

    public function init(): void
    {
        foreach ($this->sortFixtures($this->fixtures) as $fixture) {
            $fixture->load($fixture->init());
        }

        $this->flush();
    }

    public function denormalize(string $class, array $row): mixed
    {
        foreach ($this->sortFixtures($this->fixtures) as $fixture) {
            if ($class === $fixture::class) {
                return $fixture->denormalize($row);
            }
        }

        throw new \LogicException('No fixture found for this class.');
    }

    public function load(string $class, array $rows): array
    {
        foreach ($this->sortFixtures($this->fixtures) as $fixture) {
            if ($class === $fixture::class) {
                return $fixture->load($rows);
            }
        }

        throw new \LogicException('No fixture found for this class.');
    }

    public function flush(): void
    {
        foreach ($this->managerRegistry->getManagers() as $objectManager) {
            $objectManager->flush();
            $objectManager->clear();
        }

        $this->fixtureReferenceRepository->clearReferences();
    }

    public function addReference(string $key, mixed $reference): void
    {
        $this->fixtureReferenceRepository->addReference($key, $reference);
    }

    private function sortFixtures(array $fixtures): array
    {
        $sortedFixtures = $fixtures;

        foreach ($fixtures as $fixture) {
            foreach ($fixture->getDependencies() as $fixtureDependencyClass) {
                $fixtureKey = null;
                $fixtureDependencyKey = null;
                $fixtureDependency = null;

                foreach ($sortedFixtures as $index => $sortedFixture) {
                    if ($fixture::class === $sortedFixture::class) {
                        $fixtureKey = $index;
                    }

                    if ($fixtureDependencyClass === $sortedFixture::class) {
                        $fixtureDependencyKey = $index;
                        $fixtureDependency = $sortedFixture;
                    }
                }

                if (
                    null !== $fixtureKey
                    && null !== $fixtureDependencyKey
                    && null !== $fixtureDependency
                    && $fixtureDependencyKey > $fixtureKey
                ) {
                    unset($sortedFixtures[$fixtureDependencyKey]);

                    array_splice($sortedFixtures, $fixtureKey, 0, [$fixtureDependency]);
                }
            }
        }

        return $sortedFixtures;
    }
}
