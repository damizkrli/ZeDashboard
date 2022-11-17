<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        max: 50,
        maxMessage: "Votre titre ne peut contenir que {{ limit }} caractères."
    )]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $created_at = null;

    #[ORM\OneToMany(mappedBy: 'note', targetEntity: ApplyFor::class)]
    private Collection $applyFors;

    public function __construct()
    {
        $this->applyFors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, ApplyFor>
     */
    public function getApplyFors(): Collection
    {
        return $this->applyFors;
    }

    public function addApplyFor(ApplyFor $applyFor): self
    {
        if (!$this->applyFors->contains($applyFor)) {
            $this->applyFors->add($applyFor);
            $applyFor->setNote($this);
        }

        return $this;
    }

    public function removeApplyFor(ApplyFor $applyFor): self
    {
        if ($this->applyFors->removeElement($applyFor)) {
            // set the owning side to null (unless already changed)
            if ($applyFor->getNote() === $this) {
                $applyFor->setNote(null);
            }
        }

        return $this;
    }

}
