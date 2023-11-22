<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\FixtureBundle\Fixture\Fixture;
use Webmunkeez\FixtureBundle\Fixture\FixtureReferenceRepository;
use Webmunkeez\FixtureBundle\Fixture\FixtureReferenceRepositoryInterface;

return static function (ContainerConfigurator $container) {
    if (false === in_array($container->env(), ['prod', 'production'])) {
        $container->services()
            ->set(FixtureReferenceRepository::class)

            ->alias(FixtureReferenceRepositoryInterface::class, FixtureReferenceRepository::class)

            ->set(Fixture::class)
                ->args([service('doctrine'), service(FixtureReferenceRepositoryInterface::class)]);
    }
};
