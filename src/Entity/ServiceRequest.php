<?php

declare(strict_types=1);

namespace App\Entity;

use App\Domain\Services\Request\RequestStatus;
use App\Repository\ServiceRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRequestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ServiceRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serviceRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $guest = null;

    #[ORM\ManyToOne(inversedBy: 'serviceRequests')]
    private ?Employee $employee = null;

    /**
     * @var Collection<int, ServiceRequestHistory>
     */
    #[ORM\OneToMany(targetEntity: ServiceRequestHistory::class, mappedBy: 'serviceRequest', orphanRemoval: true)]
    private Collection $serviceRequestHistories;

    #[ORM\Column(length: 10)]
    private ?string $room_number = null;

    #[ORM\Column(nullable: true)]
    private ?int $created_by = null;

    #[ORM\Column(type: 'time')]
    private ?\DateTimeInterface $schedule_at = null;

    #[ORM\Column(enumType: RequestStatus::class)]
    private RequestStatus $status = RequestStatus::CREATED;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->serviceRequestHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): static
    {
        $this->guest = $guest;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection<int, ServiceRequestHistory>
     */
    public function getServiceRequestHistories(): Collection
    {
        return $this->serviceRequestHistories;
    }

    public function addServiceRequestHistory(ServiceRequestHistory $serviceRequestHistory): static
    {
        if (!$this->serviceRequestHistories->contains($serviceRequestHistory)) {
            $this->serviceRequestHistories->add($serviceRequestHistory);
            $serviceRequestHistory->setServiceRequest($this);
        }

        return $this;
    }

    public function removeServiceRequestHistory(ServiceRequestHistory $serviceRequestHistory): static
    {
        if ($this->serviceRequestHistories->removeElement($serviceRequestHistory)) {
            // set the owning side to null (unless already changed)
            if ($serviceRequestHistory->getServiceRequest() === $this) {
                $serviceRequestHistory->setServiceRequest(null);
            }
        }

        return $this;
    }

    public function getRoomNumber(): ?string
    {
        return $this->room_number;
    }

    public function setRoomNumber(string $room_number): static
    {
        $this->room_number = $room_number;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(?int $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getScheduleAt(): ?\DateTime
    {
        return $this->schedule_at;
    }

    public function setScheduleAt(\DateTime $schedule_at): static
    {
        $this->schedule_at = $schedule_at;

        return $this;
    }

    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    public function setStatus(RequestStatus $status): static
    {
        $this->status = $status;

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
}
