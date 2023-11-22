<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Webmunkeez\FixtureBundle\Fixture\FixtureInterface;
use Webmunkeez\FixtureBundle\Fixture\FixtureReferenceRepositoryInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezFixtureExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'), $container->getParameter('kernel.environment'));
        $loader->load('console.php');
        $loader->load('fixture.php');

        if (false === in_array($container->getParameter('kernel.environment'), ['prod', 'production'])) {
            $container->registerForAutoconfiguration(FixtureInterface::class)
                ->addMethodCall('setManagerRegistry', [new Reference('doctrine')])
                ->addMethodCall('setFixtureReferenceRepository', [new Reference(FixtureReferenceRepositoryInterface::class)])
                ->addTag('webmunkeez_fixture.fixture')
                ->setPublic(true);
        }
    }
}
