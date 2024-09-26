<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['animal:read']],
    denormalizationContext: ['groups' => ['animal:write']]
)]
#[ApiFilter(
    SearchFilter::class, properties: ['habitat.id' => 'exact', 'species.id' => 'exact']
)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['animal:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Habitat::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?Habitat $habitat = null;

    #[ORM\ManyToOne(targetEntity: Species::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?Species $species = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $health_status = null;

    /**
     * @var Collection<int, VeterinaryReport>
     */
    #[ORM\OneToMany(targetEntity: VeterinaryReport::class, mappedBy: 'animal')]
    private Collection $veterinaryReports;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'animal')]
    private Collection $images;

    public function __construct()
    {
        $this->veterinaryReports = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getHealthStatus(): ?string
    {
        return $this->health_status;
    }

    public function setHealthStatus(string $health_status): static
    {
        $this->health_status = $health_status;
        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;
        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;
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
            $veterinaryReport->setAnimal($this);
        }
        return $this;
    }

    public function removeVeterinaryReport(VeterinaryReport $veterinaryReport): static
    {
        if ($this->veterinaryReports->removeElement($veterinaryReport)) {
            if ($veterinaryReport->getAnimal() === $this) {
                $veterinaryReport->setAnimal(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimal($this);
        }
        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getAnimal() === $this) {
                $image->setAnimal(null);
            }
        }
        return $this;
    }
}