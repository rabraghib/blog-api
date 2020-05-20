<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $metatitle;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="categories")
     */
    private $parentId;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parentId", orphanRemoval=true)
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=BlogCategory::class, mappedBy="categoryId", orphanRemoval=true)
     */
    private $blogCategories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->blogCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMetatitle(): ?string
    {
        return $this->metatitle;
    }

    public function setMetatitle(string $metatitle): self
    {
        $this->metatitle = $metatitle;

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

    public function getParentId(): ?self
    {
        return $this->parentId;
    }

    public function setParentId(?self $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setParentId($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getParentId() === $this) {
                $category->setParentId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogCategory[]
     */
    public function getBlogCategories(): Collection
    {
        return $this->blogCategories;
    }

    public function addBlogCategory(BlogCategory $blogCategory): self
    {
        if (!$this->blogCategories->contains($blogCategory)) {
            $this->blogCategories[] = $blogCategory;
            $blogCategory->setCategoryId($this);
        }

        return $this;
    }

    public function removeBlogCategory(BlogCategory $blogCategory): self
    {
        if ($this->blogCategories->contains($blogCategory)) {
            $this->blogCategories->removeElement($blogCategory);
            // set the owning side to null (unless already changed)
            if ($blogCategory->getCategoryId() === $this) {
                $blogCategory->setCategoryId(null);
            }
        }

        return $this;
    }
}
