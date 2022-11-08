<?php

namespace App\Entity;

use App\Repository\ApplyForRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApplyForRepository::class)]
class ApplyFor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155, )]
    #[Assert\NotBlank(message: "Merci de saisir l'intitulé du poste")]
    #[Assert\Length(
        min: '2',
        max: '100',
        minMessage: "L'intitulé de votre poste doit contenir au moins {{ limit }} caractères.",
        maxMessage: "L'intitulé de votre poste ne peut contenir plus de {{ limit }} caractères."
    )]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Merci de saisir le lien vers l'annonce")]
    #[Assert\Url(message: "Merci de saisir une URL valide.", protocols: ["https", "ftp"], normalizer: "trim")]
    private ?string $link = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Merci de saisir un status")]
    private ?string $status = "Transmise";

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: "Le nom doit contenir plus de {{ limit }} caractères.",
        maxMessage: "Le nom ne doit pas contenir plus de {{ limit }} caractères."
    )]
    private ?string $contact;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: "Le nom doit contenir plus de {{ limit }} caractères.",
        maxMessage: "Le nom ne doit pas contenir plus de {{ limit }} caractères."
    )]
    private ?string $details = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "cascade")]
    private ?Company $company;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "cascade")]
    private ?Platform $platform;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

}
