<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Blogs::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogId;

    /**
     * @ORM\ManyToOne(targetEntity=comment::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parentId;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $commenter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateAt;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->lastUpdateAt = new \DateTimeImmutable();
    }

    public function onUpdate()
    {
        $this->lastUpdateAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogId(): ?Blogs
    {
        return $this->blogId;
    }

    public function setBlogId(?Blogs $blogId): self
    {
        $this->blogId = $blogId;
        $this->onUpdate();

        return $this;
    }

    public function getParentId(): ?comment
    {
        return $this->parentId;
    }

    public function setParentId(?comment $parentId): self
    {
        $this->parentId = $parentId;
        $this->onUpdate();

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        $this->onUpdate();

        return $this;
    }

    public function getCommenter(): ?User
    {
        return $this->commenter;
    }

    public function setCommenter(?User $commenter): self
    {
        $this->commenter = $commenter;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
        $this->onUpdate();
    }

}
