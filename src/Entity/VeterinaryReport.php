<?php

namespace App\Entity;

use App\Repository\VeterinaryReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VeterinaryReportRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['veterinary_report:read']],
    denormalizationContext: ['groups' => ['veterinary_report:write']]
)]
#[ApiFilter(
    SearchFilter::class, properties: ['user.id' => 'exact', 'animal.id' => 'exact']
)]
class VeterinaryReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['veterinary_report:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['veterinary_report:read', 'veterinary_report:write'])]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Animal::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['veterinary_report:read', 'veterinary_report:write'])]
    private ?Animal $animal = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    #[Groups(['veterinary_report:read', 'veterinary_report:write'])]
    private ?\DateTimeInterface $report_date = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Groups(['veterinary_report:read', 'veterinary_report:write'])]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getReportDate(): ?\DateTimeInterface
    {
        return $this->report_date;
    }

    public function setReportDate(\DateTimeInterface $report_date): static
    {
        $this->report_date = $report_date;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
