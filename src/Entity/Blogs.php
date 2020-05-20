<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogsRepository;
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
     * @ORM\Column(type="string", length=255)
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


    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->lastupdate_at = new \DateTimeImmutable();
        $this->deleted = false;
        $this->num_views = 0;
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

    public function getDeleted(): ?bool
    {
        return $this->deleted;
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

        return $this;
    }

    public function getIsPublushed(): ?bool
    {
        return $this->is_publushed;
    }

    public function setIsPublushed(bool $is_publushed): self
    {
        $this->is_publushed = $is_publushed;

        return $this;
    }

}
