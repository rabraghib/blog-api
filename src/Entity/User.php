<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "path"="/users",
 *             "normalization_context"={"groups"={"public"}}
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get"={
 *             "path"="/user/{id}",
 *             "normalization_context"={"groups"={"public"}}
 *         },
 *        "getFull"={
 *             "path"="/auth/user/{id}",
 *             "method"="GET",
 *             "controller"=App\Controller\UserControllers::class,
 *             "security"="is_granted('ROLE_ADMIN') or object == user"
 *         },
 *        "patch"={
 *            "path"="/auth/user/{id}",
 *            "security"="is_granted('ROLE_ADMIN') or object == user"
 *        },
 *        "delete"={
 *            "path"="/auth/user/{id}",
 *            "security"="is_granted('ROLE_ADMIN') or object == user"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("public")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Blogs::class, mappedBy="poster", orphanRemoval=true)
     * @Groups("public")
     */
    private $userBlogs;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("public")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("public")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups("public")
     */
    private $intro;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("public")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastLogin;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct()
    {
        $this->userBlogs = new ArrayCollection();
        $this->registeredAt = new \DateTimeImmutable();
        $this->tokenStorage = new TokenStorage();
        $this->onUpdate();
    }

    public function onUpdate()
    {
        $this->lastLogin = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $user_rules = $this->tokenStorage->getToken()->getUser()->getRoles();
        if(in_array("ROLE_ADMIN",$user_rules)){
            $this->roles = $roles;
        }
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password,string $oldPass=null): self
    {
        if(!$this->password){
            $this->password = $password;
        }elseif ($oldPass == $this->password){
            $this->password = $password;
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Blogs[]
     */
    public function getUserBlogs(): Collection
    {
        return $this->userBlogs;
    }

    public function addUserBlog(Blogs $userBlog): self
    {
        if (!$this->userBlogs->contains($userBlog)) {
            $this->userBlogs[] = $userBlog;
            $userBlog->setPoster($this);
        }

        return $this;
    }

    public function removeUserBlog(Blogs $userBlog): self
    {
        if ($this->userBlogs->contains($userBlog)) {
            $this->userBlogs->removeElement($userBlog);
            // set the owning side to null (unless already changed)
            if ($userBlog->getPoster() === $this) {
                $userBlog->setPoster(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        $this->onUpdate();

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        $this->onUpdate();

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->onUpdate();

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;
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

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

}
