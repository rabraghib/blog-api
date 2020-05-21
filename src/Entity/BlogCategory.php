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
     * @ORM\OneToOne(targetEntity=Blogs::class, inversedBy="blogCategory", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogId;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $CategoryId;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogId(): ?blogs
    {
        return $this->blogId;
    }

    public function setBlogId(blogs $blogId): self
    {
        $this->blogId = $blogId;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->CategoryId;
    }

    public function setCategoryId(?Category $CategoryId): self
    {
        $this->CategoryId = $CategoryId;

        return $this;
    }

}
