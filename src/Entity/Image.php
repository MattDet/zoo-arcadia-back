<?php

// src/Entity/Image.php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['image:read']],
    denormalizationContext: ['groups' => ['image:write']],
    filters: ['search']
)]
#[ApiFilter(SearchFilter::class, properties: ['service.id' => 'exact', 'habitat.id' => 'exact', 'animal.id' => 'exact'])]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['image:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['image:read', 'image:write'])]
    private ?string $altText = null;

    #[ORM\Column(length: 255)]
    #[Groups(['image:read', 'image:write'])]
    private ?string $path = null;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'images')]
    #[Groups(['image:read', 'image:write'])]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(targetEntity: Habitat::class, inversedBy: 'images')]
    #[Groups(['image:read', 'image:write'])]
    private ?Habitat $habitat = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'images')]
    #[Groups(['image:read', 'image:write'])]
    private ?Service $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function setAltText(string $altText): static
    {
        $this->altText = $altText;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

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

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }
}

