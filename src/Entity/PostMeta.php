<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostMetaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PostMetaRepository::class)
 */
class PostMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=blogs::class, inversedBy="postMetas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Mkey;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

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

    public function getMkey(): ?string
    {
        return $this->Mkey;
    }

    public function setMkey(string $Mkey): self
    {
        $this->Mkey = $Mkey;

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
}
