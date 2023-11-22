<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Webmunkeez\FixtureBundle\Test\Fixture\TestBundle\Doctrine\ORM\Repository\CommentDoctrineORMRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
#[ORM\Entity(CommentDoctrineORMRepository::class)]
#[ORM\Table('comment')]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id', nullable: false)]
    #[Assert\NotNull]
    private Author $author;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id', nullable: false)]
    #[Assert\NotNull]
    private Post $post;

    #[ORM\Column(name: 'message', type: 'string')]
    #[Assert\NotBlank]
    private string $message;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): self
    {
        $author->addComment($this);
        $this->author = $author;

        return $this;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $post->addComment($this);
        $this->post = $post;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
