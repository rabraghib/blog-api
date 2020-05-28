<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\OrderFilter;

#  "controller"=App\Controller\BlogController::class
/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "path"="/blogs.{_format}",
 *             "normalization_context"={"groups"={"require"}}
 *         },
 *         "post"={
 *             "path"="/auth/blog/{id}"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "path"="/blog/{id}",
 *             "security"="is_granted('ROLE_ADMIN') or object.isPublushed == 'true' or object.poster == user"
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
 * @ApiFilter(SearchFilter::class, properties={"poster": "exact"})
 * @ORM\Entity(repositoryClass=BlogsRepository::class)
 */
class Blogs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"short","require"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Groups("short")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("short")
     */
    private $mainImg;

    /**
     * @ORM\Column(type="string", length=250)
     * @Groups("short")
     */
    private $intro;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"short","require"})
     */
    private $numViews;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userBlogs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"short","require"})
     */
    public $poster;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"short","require"})
     */
    public $isPublushed;

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
     * @Groups({"short","require"})
     */
    private $Category;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"short","require"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"short","require"})
     */
    private $lastupdateAt;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->lastupdateAt = new \DateTimeImmutable();
        $this->numViews = 0;
        $this->postMetas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->blogTags = new ArrayCollection();
        $this->tokenStorage = new TokenStorage();
        $this->poster = $this->tokenStorage->getToken()->getUser();
    }

    public function onUpdate()
    {
        $this->lastupdateAt = new \DateTimeImmutable();
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
        $this->onUpdate();

        return $this;
    }

    public function getMainImg(): ?string
    {
        return $this->mainImg;
    }

    public function setMainImg(string $mainImg): self
    {
        $this->mainImg = $mainImg;

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

    public function getNumViews(): ?int
    {
        return $this->numViews;
    }

    public function IncrementViews(): self
    {
        $this->numViews++;
        $this->onUpdate();

        return $this;
    }

    public function getPoster(): ?User
    {
        return $this->poster;
    }
/*
    public function setPoster(User $poster): self
    {
        $this->poster = $poster;
        $this->onUpdate();

        return $this;
    }
*/
    public function getIsPublushed(): ?bool
    {
        return $this->isPublushed;
    }

    public function setIsPublushed(bool $isPublushed): self
    {
        $this->isPublushed = $isPublushed;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLastupdateAt(): ?\DateTimeInterface
    {
        return $this->lastupdateAt;
    }

}
