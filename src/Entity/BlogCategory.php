<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BlogCategoryRepository::class)
 */
class BlogCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=blogs::class, inversedBy="blogCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blog_id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="blogCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogId(): ?blogs
    {
        return $this->blog_id;
    }

    public function setBlogId(?blogs $blog_id): self
    {
        $this->blog_id = $blog_id;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->categoryId;
    }

    public function setCategoryId(?Category $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}
