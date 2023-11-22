<?php

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Fixture;

final class FixtureReferenceRepository implements FixtureReferenceRepositoryInterface
{
    private array $references;

    public function __construct()
    {
        // init values
        $this->references = [];
    }

    public function getReference(string $key): mixed
    {
        return $this->references[$key];
    }

    public function addReference(string $key, mixed $reference): void
    {
        $this->references[$key] = $reference;
    }

    public function clearReferences(): void
    {
        $this->references = [];
    }
}
