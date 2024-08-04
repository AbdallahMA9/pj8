<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[Assert\NotNull(message: "Le projet ne doit pas être nul.")]
    private ?Project $projectId = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[Assert\NotNull(message: "Le statut ne doit pas être nul.")]
    private ?Statut $statutId = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne doit pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le titre ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description ne doit pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date limite ne doit pas être nulle.")]
    #[Assert\Type("\DateTimeInterface", message: "La date limite doit être une date valide.")]
    private ?\DateTimeInterface $deadline = null;

    /**
     * @var Collection<int, Crenaux>
     */
    #[ORM\OneToMany(targetEntity: Crenaux::class, mappedBy: 'taskId')]
    private Collection $crenauxes;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[Assert\NotNull(message: "L'utilisateur ne doit pas être nul.")]
    private ?User $userId = null;

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
            if ($crenaux->getTaskId() === $this) {
                $crenaux->setTaskId(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
