<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Webmunkeez\FixtureBundle\DependencyInjection\Compiler\AddFixturePass;
use Webmunkeez\FixtureBundle\Fixture\Fixture;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Fixture\AuthorFixture;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Fixture\PostFixture;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class AddFixturePassTest extends TestCase
{
    private AddFixturePass $pass;

    private ContainerBuilder $container;

    private Definition $managerDefinition;

    protected function setUp(): void
    {
        $this->pass = new AddFixturePass();
        $this->container = new ContainerBuilder();
        $this->managerDefinition = new Definition();

        $this->container->setDefinition(Fixture::class, $this->managerDefinition);
    }

    public function testProcessShouldSucceed(): void
    {
        $postFixture = (new Definition())
            ->setClass(PostFixture::class)
            ->setTags(['webmunkeez_fixture.fixture' => [
                    [
                        'priority' => 10,
                    ],
                ],
            ]);

        $this->container->setDefinition(PostFixture::class, $postFixture);

        $authorFixture = (new Definition())
            ->setClass(AuthorFixture::class)
            ->setTags(['webmunkeez_fixture.fixture' => [
                    [
                        'priority' => 0,
                    ],
                ],
            ]);

        $this->container->setDefinition(AuthorFixture::class, $authorFixture);

        $this->pass->process($this->container);

        $methodCalls = $this->managerDefinition->getMethodCalls();

        $this->assertCount(2, $methodCalls);
        $this->assertEqualsCanonicalizing(['addFixture', [new Reference(PostFixture::class)]], $methodCalls[0]);
        $this->assertEqualsCanonicalizing(['addFixture', [new Reference(AuthorFixture::class)]], $methodCalls[1]);
    }
}
