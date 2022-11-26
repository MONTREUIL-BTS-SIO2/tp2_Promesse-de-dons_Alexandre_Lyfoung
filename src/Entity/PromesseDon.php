<?php

namespace App\Entity;

use App\Repository\PromesseDonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromesseDonRepository::class)]
class PromesseDon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $montantDon = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateDeCreation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateHonore = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMontantDon(): ?int
    {
        return $this->montantDon;
    }

    public function setMontantDon(int $montantDon): self
    {
        $this->montantDon = $montantDon;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeImmutable
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(\DateTimeImmutable $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getDateHonore(): ?\DateTimeImmutable
    {
        return $this->dateHonore;
    }

    public function setDateHonore(?\DateTimeImmutable $dateHonore): self
    {
        $this->dateHonore = $dateHonore;

        return $this;
    }
}
