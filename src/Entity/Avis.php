<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
 */
class Avis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner un auteur!")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner un contenu à l'avis!")
     */
    private $contenu;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Veuillez renseigner une note sur 5!")
     * @Assert\Length(min=0, max=5 ,exactMessage= "Note comprise entre 0 et 5!")
     */
    private $note_accueil;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Veuillez renseigner une note sur 5!")
     * @Assert\Length(min=0, max=5 ,exactMessage= "Note comprise entre 0 et 5!")
     */
    private $note_pro;

    /**
     * @ORM\ManyToOne(targetEntity=Medecins::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecins;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateurs;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner un contenu à l'avis!")
     */
    private $auteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getNoteAccueil(): ?int
    {
        return $this->note_accueil;
    }

    public function setNoteAccueil(int $note_accueil): self
    {
        $this->note_accueil = $note_accueil;

        return $this;
    }

    public function getNotePro(): ?int
    {
        return $this->note_pro;
    }

    public function setNotePro(int $note_pro): self
    {
        $this->note_pro = $note_pro;

        return $this;
    }

    public function getMedecins(): ?Medecins
    {
        return $this->medecins;
    }

    public function setMedecins(?Medecins $medecins): self
    {
        $this->medecins = $medecins;

        return $this;
    }

    public function getUtilisateurs(): ?Utilisateurs
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?Utilisateurs $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
