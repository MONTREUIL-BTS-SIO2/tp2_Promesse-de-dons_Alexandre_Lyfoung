<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'string',
        message: 'La valeur $nom n\'est pas de type String'
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min:0,
        max:2000
    )]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'campagne', targetEntity: PromesseDon::class)]
    private Collection $promesseDons;

    public function __construct()
    {
        $this->promesseDons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, PromesseDon>
     */
    public function getPromesseDons(): Collection
    {
        return $this->promesseDons;
    }

    public function addPromesseDon(PromesseDon $promesseDon): self
    {
        if (!$this->promesseDons->contains($promesseDon)) {
            $this->promesseDons->add($promesseDon);
            $promesseDon->setCampagne($this);
        }

        return $this;
    }

    public function removePromesseDon(PromesseDon $promesseDon): self
    {
        if ($this->promesseDons->removeElement($promesseDon)) {
            // set the owning side to null (unless already changed)
            if ($promesseDon->getCampagne() === $this) {
                $promesseDon->setCampagne(null);
            }
        }

        return $this;
    }
}
