<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Webmunkeez\CQRSBundle\Doctrine\ORM\Repository\AbstractDoctrineORMRepository;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model\Comment;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommentDoctrineORMRepository extends AbstractDoctrineORMRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
}
