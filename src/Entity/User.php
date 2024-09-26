<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[ApiFilter(
    SearchFilter::class, properties: ['role.id' => 'exact']
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write'])]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $first_name = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    private ?string $last_name = null;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'user:write'])]
    private ?Role $role = null;

    /**
     * @var Collection<int, VeterinaryReport>
     */
    #[ORM\OneToMany(targetEntity: VeterinaryReport::class, mappedBy: 'user')]
    private Collection $veterinaryReports;

    public function __construct()
    {
        $this->veterinaryReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, VeterinaryReport>
     */
    public function getVeterinaryReports(): Collection
    {
        return $this->veterinaryReports;
    }

    public function addVeterinaryReport(VeterinaryReport $veterinaryReport): static
    {
        if (!$this->veterinaryReports->contains($veterinaryReport)) {
            $this->veterinaryReports->add($veterinaryReport);
            $veterinaryReport->setUser($this);
        }

        return $this;
    }

    public function removeVeterinaryReport(VeterinaryReport $veterinaryReport): static
    {
        if ($this->veterinaryReports->removeElement($veterinaryReport)) {
            // set the owning side to null (unless already changed)
            if ($veterinaryReport->getUser() === $this) {
                $veterinaryReport->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role?->getRoleName() ?? 'ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null; // Passwords should be hashed by a password encoder
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
}
