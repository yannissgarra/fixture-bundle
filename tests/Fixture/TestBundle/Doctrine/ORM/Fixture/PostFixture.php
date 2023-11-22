<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Fixture;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\FixtureBundle\Fixture\AbstractFixture;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model\Post;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class PostFixture extends AbstractFixture
{
    public const DATA = [
        'author_reference' => 'author_1',
        'title' => 'Post 1',
    ];

    public function init(): array
    {
        return [
            'post_1' => self::DATA,
            'post_2' => array_merge(self::DATA, ['title' => 'Post 2']),
        ];
    }

    public function denormalize(array $row): Post
    {
        return (new Post())
            ->setId(Uuid::v4())
            ->setAuthor($this->getReference($row['author_reference']))
            ->setTitle($row['title']);
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
        ];
    }
}
