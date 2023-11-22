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
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model\Comment;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommentFixture extends AbstractFixture
{
    public const DATA = [
        'author_reference' => 'author_1',
        'post_reference' => 'post_1',
        'message' => 'Comment 1',
    ];

    public function init(): array
    {
        return [
            'comment_1' => self::DATA,
            'comment_2' => array_merge(self::DATA, ['author_reference' => 'author_2', 'message' => 'Comment 2']),
            'comment_3' => array_merge(self::DATA, ['author_reference' => 'author_2', 'post_reference' => 'post_2', 'message' => 'Comment 3']),
        ];
    }

    public function denormalize(array $row): Comment
    {
        return (new Comment())
            ->setId(Uuid::v4())
            ->setAuthor($this->getReference($row['author_reference']))
            ->setPost($this->getReference($row['post_reference']))
            ->setMessage($row['message']);
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
            PostFixture::class,
        ];
    }
}
