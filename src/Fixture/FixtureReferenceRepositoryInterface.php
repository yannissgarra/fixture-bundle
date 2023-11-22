<?php

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Fixture;

interface FixtureReferenceRepositoryInterface
{
    public function getReference(string $key): mixed;

    public function addReference(string $key, mixed $reference): void;

    public function clearReferences(): void;
}
