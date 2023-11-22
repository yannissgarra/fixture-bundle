<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webmunkeez\FixtureBundle\DependencyInjection\Compiler\AddFixturePass;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezFixtureBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddFixturePass());
    }
}
