<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateAffectation;

    /**
     * @ORM\Column(type="boolean", nullable=true )
     */
    private $validation;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;


    /**
     * @ORM\OneToMany(targetEntity=DemandeStage::class, mappedBy="stage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demandeStages;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="stage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;


    public function __construct()
    {
        $this->demandeStages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->dateAffectation;
    }

    public function setDateAffectation(\DateTimeInterface $dateAffectation): self
    {
        $this->dateAffectation = $dateAffectation;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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
            $demandeStage->setStage($this);
        }

        return $this;
    }

    public function removeDemandeStage(DemandeStage $demandeStage): self
    {
        if ($this->demandeStages->removeElement($demandeStage)) {
            // set the owning side to null (unless already changed)
            if ($demandeStage->getStage() === $this) {
                $demandeStage->setStage(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

}
