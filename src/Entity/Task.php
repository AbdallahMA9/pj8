<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Project $projectId = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Statut $statutId = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $deadline = null;

    /**
     * @var Collection<int, Crenaux>
     */
    #[ORM\OneToMany(targetEntity: Crenaux::class, mappedBy: 'taskId')]
    private Collection $crenauxes;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?user $userId = null;

    public function __construct()
    {
        $this->crenauxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getProjectId(): ?Project
    {
        return $this->projectId;
    }

    public function setProjectId(?Project $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getStatutId(): ?Statut
    {
        return $this->statutId;
    }

    public function setStatutId(?Statut $statutId): static
    {
        $this->statutId = $statutId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return Collection<int, Crenaux>
     */
    public function getCrenauxes(): Collection
    {
        return $this->crenauxes;
    }

    public function addCrenaux(Crenaux $crenaux): static
    {
        if (!$this->crenauxes->contains($crenaux)) {
            $this->crenauxes->add($crenaux);
            $crenaux->setTaskId($this);
        }

        return $this;
    }

    public function removeCrenaux(Crenaux $crenaux): static
    {
        if ($this->crenauxes->removeElement($crenaux)) {
            // set the owning side to null (unless already changed)
            if ($crenaux->getTaskId() === $this) {
                $crenaux->setTaskId(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
