<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    //AJOUTER UNE CAUSE POUR L'ANNULATION
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=150)
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan("today")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $limitSubDate;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $infos;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxSub;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Groups ("campusNames")
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="event", cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="organiser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organiser;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreated;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getLimitSubDate(): ?\DateTimeInterface
    {
        return $this->limitSubDate;
    }

    public function setLimitSubDate(\DateTimeInterface $limitSubDate): self
    {
        $this->limitSubDate = $limitSubDate;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getMaxSub(): ?int
    {
        return $this->maxSub;
    }

    public function setMaxSub(int $maxSub): self
    {
        $this->maxSub = $maxSub;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->subscribeEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->unsubscribeEvent($this);
        }

        return $this;
    }

    public function getOrganiser(): ?User
    {
        return $this->organiser;
    }

    public function setOrganiser(?User $organiser): self
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->DateCreated;
    }

    public function setDateCreated(\DateTimeInterface $DateCreated): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

}
