<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`User`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "L'email ne doit pas être vide.")]
    #[Assert\Email(
        message: "L'adresse email '{{ value }}' n'est pas une adresse valide.",
        checkMX: true
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom ne doit pas être vide.")]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne doit pas être vide.")]
    private ?string $lastName = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le rôle ne doit pas être nul.")]
    private ?bool $role = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La vérification ne doit pas être nulle.")]
    private ?bool $isVerified = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La date de début ne doit pas être nulle.")]
    #[Assert\Type("\DateTimeImmutable", message: "La date de début doit être une date valide.")]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le contrat ne doit pas être vide.")]
    private ?string $contract = null;

    #[ORM\OneToMany(targetEntity: Crenaux::class, mappedBy: 'userId')]
    private Collection $crenauxes;

    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'userId')]
    private Collection $tasks;

    public function __construct()
    {
        $this->crenauxes = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isRole(): ?bool
    {
        return $this->role;
    }

    public function setRole(bool $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): static
    {
        $this->contract = $contract;

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
            $crenaux->setUserId($this);
        }

        return $this;
    }

    public function removeCrenaux(Crenaux $crenaux): static
    {
        if ($this->crenauxes->removeElement($crenaux)) {
            if ($crenaux->getUserId() === $this) {
                $crenaux->setUserId(null);
            }
        }

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setUserId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            if ($task->getUserId() === $this) {
                $task->setUserId(null);
            }
        }

        return $this;
    }
}
