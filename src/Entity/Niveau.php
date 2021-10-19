<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity=DemandeStage::class, mappedBy="niveau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demandeStages;

    /**
     * @ORM\ManyToMany(targetEntity=OffreStage::class, mappedBy="niveau")
     */
    private $offreStages;

    public function __construct()
    {
        $this->demandeStages = new ArrayCollection();
        $this->offreStages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|DemandeStage[]
     */
    public function getDemandeStages(): Collection
    {
        return $this->demandeStages;
    }

    public function addDemandeStage(DemandeStage $demandeStage): self
    {
        if (!$this->demandeStages->contains($demandeStage)) {
            $this->demandeStages[] = $demandeStage;
            $demandeStage->setNiveau($this);
        }

        return $this;
    }

    public function removeDemandeStage(DemandeStage $demandeStage): self
    {
        if ($this->demandeStages->removeElement($demandeStage)) {
            // set the owning side to null (unless already changed)
            if ($demandeStage->getNiveau() === $this) {
                $demandeStage->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OffreStage[]
     */
    public function getOffreStages(): Collection
    {
        return $this->offreStages;
    }

    public function addOffreStage(OffreStage $offreStage): self
    {
        if (!$this->offreStages->contains($offreStage)) {
            $this->offreStages[] = $offreStage;
            $offreStage->addNiveau($this);
        }

        return $this;
    }

    public function removeOffreStage(OffreStage $offreStage): self
    {
        if ($this->offreStages->removeElement($offreStage)) {
            $offreStage->removeNiveau($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation;
    }
}
