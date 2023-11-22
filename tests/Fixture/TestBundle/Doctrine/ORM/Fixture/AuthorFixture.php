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
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model\Author;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class AuthorFixture extends AbstractFixture
{
    public const DATA = [
        'name' => 'Author 1',
    ];

    public function init(): array
    {
        return [
            'author_1' => self::DATA,
            'author_2' => array_merge(self::DATA, ['name' => 'Author 2']),
        ];
    }

    public function denormalize(array $row): Author
    {
        return (new Author())
            ->setId(Uuid::v4())
            ->setName($row['name']);
    }
}
