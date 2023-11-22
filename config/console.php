<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\FixtureBundle\Console\Command\FixtureInitConsoleCommand;
use Webmunkeez\FixtureBundle\Fixture\Fixture;

return function (ContainerConfigurator $container) {
    $container->services()
        ->set(FixtureInitConsoleCommand::class)
            ->args([service(Fixture::class)])
            ->tag('console.command', ['command' => 'webmunkeez:fixture:init']);
};
