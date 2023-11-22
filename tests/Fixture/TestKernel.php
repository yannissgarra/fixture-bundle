<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\Fixture;

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Webmunkeez\CQRSBundle\WebmunkeezCQRSBundle;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\TestBundle;
use Webmunkeez\FixtureBundle\WebmunkeezFixtureBundle;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new DoctrineBundle(),
            new DAMADoctrineTestBundle(),
            new FrameworkBundle(),
            new WebmunkeezCQRSBundle(),
            new WebmunkeezFixtureBundle(),
            new TestBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config.yaml');
        $loader->load(__DIR__.'/config/doctrine.yaml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
