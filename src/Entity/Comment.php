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
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdate_at;

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

        return $this;
    }

    public function getParentId(): ?comment
    {
        return $this->parentId;
    }

    public function setParentId(?comment $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdate_at;
    }

    public function setLastUpdateAt(\DateTimeInterface $lastUpdate_at): self
    {
        $this->lastUpdate_at = $lastUpdate_at;

        return $this;
    }
}
