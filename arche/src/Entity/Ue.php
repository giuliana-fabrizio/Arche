<?php

namespace App\Entity;

use App\Repository\UeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UeRepository::class)]
class Ue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?string $code = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'ues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $fk_category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Section>
     */
    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'fk_ue', orphanRemoval: true)]
    private Collection $sections;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'associates_ues')]
    private Collection $associates_users;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->associates_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getFkCategory(): ?Category
    {
        return $this->fk_category;
    }

    public function setFkCategory(?Category $fk_category): static
    {
        $this->fk_category = $fk_category;

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->user;
    }

    public function setFkUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setFkUe($this);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($this->sections->removeElement($section)) {
            if ($section->getFkUe() === $this) {
                $section->setFkUe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAssociatesUsers(): Collection
    {
        return $this->associates_users;
    }

    public function addAssociatesUser(User $associatesUser): static
    {
        if (!$this->associates_users->contains($associatesUser)) {
            $this->associates_users->add($associatesUser);
            $associatesUser->addAssociatesUe($this);
        }

        return $this;
    }

    public function removeAssociatesUser(User $associatesUser): static
    {
        if ($this->associates_users->removeElement($associatesUser)) {
            $associatesUser->removeAssociatesUe($this);
        }

        return $this;
    }
}
