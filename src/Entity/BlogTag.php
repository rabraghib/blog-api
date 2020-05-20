<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BlogTagRepository::class)
 */
class BlogTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=blogs::class, inversedBy="blogTags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogId;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $tagId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogId(): ?blogs
    {
        return $this->blogId;
    }

    public function setBlogId(?blogs $blogId): self
    {
        $this->blogId = $blogId;

        return $this;
    }

    public function getTagId(): ?Tag
    {
        return $this->tagId;
    }

    public function setTagId(?Tag $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }
}
