<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlogsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
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
     * @ORM\Column(type="string", length=100)
     */
    private $poster_username;

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

    public function getPosterUsername(): ?string
    {
        return $this->poster_username;
    }

    public function setPosterUsername(string $poster_username): self
    {
        $this->poster_username = $poster_username;
        $this->onUpdate();

        return $this;
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

}
