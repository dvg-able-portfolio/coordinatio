<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, ServiceCategory>
     */
    #[ORM\ManyToMany(targetEntity: ServiceCategory::class, inversedBy: 'services')]
    private Collection $categories;

    #[ORM\Column]
    private ?bool $is_schedulable = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $available_from = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $available_to = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isSchedulable(): ?bool
    {
        return $this->is_schedulable;
    }

    public function setIsSchedulable(bool $is_schedulable): static
    {
        $this->is_schedulable = $is_schedulable;

        return $this;
    }

    public function getAvailableFrom(): ?string
    {
        return $this->available_from;
    }

    public function setAvailableFrom(string $available_from): static
    {
        $this->available_from = $available_from;

        return $this;
    }

    public function getAvailableTo(): ?string
    {
        return $this->available_to;
    }

    public function setAvailableTo(?string $available_to): static
    {
        $this->available_to = $available_to;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * @return Collection<int, ServiceCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ServiceCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(ServiceCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
