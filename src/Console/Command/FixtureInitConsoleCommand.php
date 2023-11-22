<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmunkeez\FixtureBundle\Fixture\Fixture;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class FixtureInitConsoleCommand extends Command
{
    private Fixture $fixture;

    public function __construct(Fixture $fixture)
    {
        parent::__construct();

        $this->fixture = $fixture;
    }

    protected function configure(): void
    {
        $this->setDescription('Init fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->fixture->init();

        $output->writeln('The fixtures have been initiated.');

        return Command::SUCCESS;
    }
}
