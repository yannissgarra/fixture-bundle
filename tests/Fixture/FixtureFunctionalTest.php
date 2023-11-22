<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\FixtureBundle\Fixture\Fixture;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Fixture\AuthorFixture;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model\Author;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Repository\AuthorDoctrineORMRepository;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Repository\CommentDoctrineORMRepository;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Repository\PostDoctrineORMRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class FixtureFunctionalTest extends KernelTestCase
{
    public function testInitShouldSucceed(): void
    {
        static::getContainer()->get(Fixture::class)->init();

        $authorsTotal = static::getContainer()->get(AuthorDoctrineORMRepository::class)->count([]);
        $this->assertSame(2, $authorsTotal);

        $postsTotal = static::getContainer()->get(PostDoctrineORMRepository::class)->count([]);
        $this->assertSame(2, $postsTotal);

        $commentsTotal = static::getContainer()->get(CommentDoctrineORMRepository::class)->count([]);
        $this->assertSame(3, $commentsTotal);
    }

    public function testDenormalizeShouldSucceed(): void
    {
        $author1 = static::getContainer()->get(Fixture::class)->denormalize(AuthorFixture::class, AuthorFixture::DATA);

        $this->assertSame(AuthorFixture::DATA['name'], $author1->getName());
    }

    public function testLoadShouldSucceed(): void
    {
        /** @var array<Author> */
        $authorFixtures = static::getContainer()->get(Fixture::class)->load(AuthorFixture::class, [
            'author_1' => AuthorFixture::DATA,
            'author_2' => array_merge(AuthorFixture::DATA, ['name' => 'Author 2']),
        ]);

        $authorsTotal = static::getContainer()->get(AuthorDoctrineORMRepository::class)->count([]);
        $this->assertSame(0, $authorsTotal);

        $this->assertInstanceOf(Author::class, $authorFixtures['author_1']);
        $this->assertSame(AuthorFixture::DATA['name'], $authorFixtures['author_1']->getName());
        $this->assertInstanceOf(Author::class, $authorFixtures['author_2']);
        $this->assertSame('Author 2', $authorFixtures['author_2']->getName());
    }

    public function testFlushShouldSucceed(): void
    {
        /** @var array<Author> */
        $authorFixtures = static::getContainer()->get(Fixture::class)->load(AuthorFixture::class, [
            'author_1' => AuthorFixture::DATA,
            'author_2' => array_merge(AuthorFixture::DATA, ['name' => 'Author 2']),
        ]);

        static::getContainer()->get(Fixture::class)->flush();

        $authorsTotal = static::getContainer()->get(AuthorDoctrineORMRepository::class)->count([]);
        $this->assertSame(2, $authorsTotal);

        $this->assertSame(AuthorFixture::DATA['name'], static::getContainer()->get(AuthorDoctrineORMRepository::class)->find($authorFixtures['author_1']->getId())->getName());
        $this->assertSame('Author 2', static::getContainer()->get(AuthorDoctrineORMRepository::class)->find($authorFixtures['author_2']->getId())->getName());
    }
}
