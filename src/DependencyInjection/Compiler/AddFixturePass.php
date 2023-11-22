<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmunkeez\FixtureBundle\Fixture\Fixture;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class AddFixturePass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasDefinition(Fixture::class)) {
            return;
        }

        $definition = $container->getDefinition(Fixture::class);

        foreach ($this->findAndSortTaggedServices('webmunkeez_fixture.fixture', $container) as $reference) {
            $definition->addMethodCall('addFixture', [$reference]);
        }
    }
}
