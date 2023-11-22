<?php

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Fixture;

use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractFixture implements FixtureInterface
{
    private ManagerRegistry $managerRegistry;

    private FixtureReferenceRepository $fixtureReferenceRepository;

    public function setManagerRegistry(ManagerRegistry $managerRegistry): void
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function setFixtureReferenceRepository(FixtureReferenceRepository $fixtureReferenceRepository): void
    {
        $this->fixtureReferenceRepository = $fixtureReferenceRepository;
    }

    public function init(): array
    {
        return [];
    }

    public function load(array $rows): array
    {
        $models = [];

        foreach ($rows as $reference => $row) {
            $model = $this->denormalize($row);

            $this->managerRegistry->getManagerForClass($model::class)->persist($model);

            $this->fixtureReferenceRepository->addReference($reference, $model);

            $models[$reference] = $model;
        }

        return $models;
    }

    protected function getReference(string $key): mixed
    {
        return $this->fixtureReferenceRepository->getReference($key);
    }

    public function getDependencies(): array
    {
        return [];
    }
}
