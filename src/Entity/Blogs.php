<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BlogsRepository::class)
 */
class Blogs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $main_img;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=700)
     */
    private $intro;
    
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
    private $lastupdate_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_views;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_blogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_publushed;

    /**
     * @ORM\OneToMany(targetEntity=PostMeta::class, mappedBy="blogId", orphanRemoval=true)
     */
    private $postMetas;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="blogId", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=BlogTag::class, mappedBy="blogId", orphanRemoval=true)
     */
    private $blogTags;

    /**
     * @ORM\OneToOne(targetEntity=BlogCategory::class, mappedBy="blogId", cascade={"persist", "remove"})
     */
    private $blogCategory;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->lastupdate_at = new \DateTimeImmutable();
        $this->deleted = false;
        $this->num_views = 0;
        $this->postMetas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->blogTags = new ArrayCollection();
        $this->blogCategories = new ArrayCollection();
    }

    public function onUpdate()
    {
        $this->lastupdate_at = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainImg(): ?string
    {
        return $this->main_img;
    }

    public function setMainImg(string $main_img): self
    {
        $this->main_img = $main_img;
        $this->onUpdate();

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->onUpdate();

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function getLastupdateAt(): ?\DateTimeInterface
    {
        return $this->lastupdate_at;
    }


    public function getNumViews(): ?int
    {
        return $this->num_views;
    }

    public function IncrementViews(): self
    {
        $this->num_views++;
        $this->onUpdate();

        return $this;
    }

    public function DeleteBlog(bool $deleted): self
    {
        $this->deleted = $deleted;
        $this->onUpdate();

        return $this;
    }

    public function getPoster(): ?User
    {
        return $this->poster;
    }

    public function setPoster(?User $poster): self
    {
        $this->poster = $poster;
        $this->onUpdate();

        return $this;
    }

    public function getIsPublushed(): ?bool
    {
        return $this->is_publushed;
    }

    public function setIsPublushed(bool $is_publushed): self
    {
        $this->is_publushed = $is_publushed;
        $this->onUpdate();

        return $this;
    }

    /**
     * @return Collection|PostMeta[]
     */
    public function getPostMetas(): Collection
    {
        return $this->postMetas;
    }

    public function addPostMeta(PostMeta $postMeta): self
    {
        if (!$this->postMetas->contains($postMeta)) {
            $this->postMetas[] = $postMeta;
            $postMeta->setBlogId($this);
        }

        return $this;
    }

    public function removePostMeta(PostMeta $postMeta): self
    {
        if ($this->postMetas->contains($postMeta)) {
            $this->postMetas->removeElement($postMeta);
            // set the owning side to null (unless already changed)
            if ($postMeta->getBlogId() === $this) {
                $postMeta->setBlogId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBlogId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getBlogId() === $this) {
                $comment->setBlogId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogTag[]
     */
    public function getBlogTags(): Collection
    {
        return $this->blogTags;
    }

    public function addBlogTag(BlogTag $blogTag): self
    {
        if (!$this->blogTags->contains($blogTag)) {
            $this->blogTags[] = $blogTag;
            $blogTag->setBlogId($this);
        }

        return $this;
    }

    public function removeBlogTag(BlogTag $blogTag): self
    {
        if ($this->blogTags->contains($blogTag)) {
            $this->blogTags->removeElement($blogTag);
            // set the owning side to null (unless already changed)
            if ($blogTag->getBlogId() === $this) {
                $blogTag->setBlogId(null);
            }
        }

        return $this;
    }

    public function getBlogCategory(): ?BlogCategory
    {
        return $this->blogCategory;
    }

    public function setBlogCategory(BlogCategory $blogCategory): self
    {
        $this->blogCategory = $blogCategory;

        // set the owning side of the relation if necessary
        if ($blogCategory->getBlogId() !== $this) {
            $blogCategory->setBlogId($this);
        }

        return $this;
    }

}
