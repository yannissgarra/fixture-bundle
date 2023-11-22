<?php

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Fixture;

interface FixtureInterface
{
    public function setFixtureReferenceRepository(FixtureReferenceRepository $fixtureReferenceRepository): void;

    public function init(): array;

    public function denormalize(array $row): mixed;

    public function load(array $rows): array;

    public function getDependencies(): array;
}
