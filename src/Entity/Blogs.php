<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#  "controller"=App\Controller\BlogController::class
/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "path"="/blogs",
 *             "normalization_context"={"groups"={"short"}},
 *             "security"="is_granted('ROLE_ADMIN') or object.is_publushed == 'true' or object.poster == user"
 *         },
 *         "post"={
 *             "path"="/auth/blog/{id}"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "path"="/blog/{id}",
 *             "security"="is_granted('ROLE_ADMIN') or object.is_publushed == 'true' or object.poster == user"
 *         },
 *        "patch"={
 *            "path"="/auth/blog/{id}",
 *            "security"="is_granted('ROLE_ADMIN') or object.poster == user"
 *        },
 *        "delete"={
 *            "path"="/auth/blog/{id}",
 *            "security"="is_granted('ROLE_ADMIN') or object.poster == user"
 *         }
 *     }
 * )
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
     * @Groups("short")
     */
    private $main_img;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("short")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=700)
     * @Groups("short")
     */
    private $intro;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("short")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("short")
     */
    private $lastupdate_at;

    /**
     * @ORM\Column(type="integer")
     * @Groups("short")
     */
    private $num_views;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user_blogs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("short")
     */
    private $poster;

    /**
     * @ORM\Column(type="boolean")
     */
    public $is_publushed;

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
     * @Groups("short")
     */
    private $blogTags;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="blogs")
     */
    private $Category;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->created_at = new \DateTimeImmutable();
        $this->lastupdate_at = new \DateTimeImmutable();
        $this->num_views = 0;
        $this->postMetas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->blogTags = new ArrayCollection();
        $this->blogCategories = new ArrayCollection();
        $this->poster = $tokenStorage->getToken()->getUser();
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

    public function getPoster(): ?User
    {
        return $this->poster;
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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

}
