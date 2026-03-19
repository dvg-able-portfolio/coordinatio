<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRequestHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRequestHistoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ServiceRequestHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serviceRequestHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceRequest $serviceRequest = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $previous_status = null;

    #[ORM\Column(length: 10)]
    private ?string $new_status = null;

    #[ORM\Column(nullable: true)]
    private ?int $changed_by = null;

    #[ORM\Column]
    private ?\DateTime $changed_at = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getServiceRequest(): ?ServiceRequest
    {
        return $this->serviceRequest;
    }

    public function setServiceRequest(?ServiceRequest $serviceRequest): static
    {
        $this->serviceRequest = $serviceRequest;

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

    public function getPreviousStatus(): ?string
    {
        return $this->previous_status;
    }

    public function setPreviousStatus(?string $previous_status): static
    {
        $this->previous_status = $previous_status;

        return $this;
    }

    public function getNewStatus(): ?string
    {
        return $this->new_status;
    }

    public function setNewStatus(string $new_status): static
    {
        $this->new_status = $new_status;

        return $this;
    }

    public function getChangedBy(): ?int
    {
        return $this->changed_by;
    }

    public function setChangedBy(?int $changed_by): static
    {
        $this->changed_by = $changed_by;

        return $this;
    }

    public function getChangedAt(): ?\DateTime
    {
        return $this->changed_at;
    }

    public function setChangedAt(\DateTime $changed_at): static
    {
        $this->changed_at = $changed_at;

        return $this;
    }
}
