<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
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
     */
    private $email;

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
     * @ORM\Column(type="string", length=12)
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $gender = [];

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="array")
     */
    private $sportsHall = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $goal = [];

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $availability;

    /**
     * @ORM\Column(type="array")
     */
    private $trainingPartner = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getGender(): ?array
    {
        return $this->gender;
    }

    public function setGender(array $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getSportsHall(): ?array
    {
        return $this->sportsHall;
    }

    public function setSportsHall(array $sportsHall): self
    {
        $this->sportsHall = $sportsHall;

        return $this;
    }

    public function getGoal(): ?array
    {
        return $this->goal;
    }

    public function setGoal(?array $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getAvailability(): ?\DateTimeInterface
    {
        return $this->availability;
    }

    public function setAvailability(?\DateTimeInterface $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getTrainingPartner(): ?array
    {
        return $this->trainingPartner;
    }

    public function setTrainingPartner(array $trainingPartner): self
    {
        $this->trainingPartner = $trainingPartner;

        return $this;
    }
}
