<?php

namespace App\Entity;

use App\Repository\MedecinsRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=MedecinsRepository::class)
 * @UniqueEntity(
 *      fields = {"email"},
 *      message = "Un compte est déjà existant à cette adresse Email !!"
 * )
 */
class Medecins implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner votre nom!")
     * @Assert\Length(
     * min= 2,max= 30, minMessage="Nom trop court",
     * maxMessage="Nom trop long")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner votre prénom!")
     * @Assert\Length(
     * min= 2,max= 30, minMessage="Prénom trop court",
     * maxMessage="Prénom trop long")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Veuillez renseigner votre numéro!")
     * @Assert\Length(min=10, max=10 ,exactMessage= "Numéro incorrect")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $centre_medical;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner votre adresse!")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Veuillez renseigner un code postal!")
     * @Assert\Length(min=5, max=5 ,exactMessage= "Code postal incorrect")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     * * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner une ville!")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner une adresse Email!")
     * @Assert\Email(message = "Veuillez saisir une adresse Email valide!")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner un mot de passe!",groups={"inscription"})
     * @Assert\EqualTo(propertyPath="confirm_password",
     * message="Les mots de passe ne correspondent pas",groups={"inscription"})
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "Veuillez confirmer votre mot de passe!",groups={"inscription"})
     * @Assert\EqualTo(propertyPath="password",
     * message="Les mots de passe ne correspondent pas",groups={"inscription"})
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez renseigner les horaires!")
     */
    private $horaires;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="medecins")
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="medecins")
     */
    private $avis;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="medecins")
     * @ORM\JoinColumn(nullable=true)
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="medecins", orphanRemoval=true)
     */
    private $rdvs;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCentreMedical(): ?string
    {
        return $this->centre_medical;
    }

    public function setCentreMedical(?string $centre_medical): self
    {
        $this->centre_medical = $centre_medical;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(string $horaires): self
    {
        $this->horaires = $horaires;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setMedecins($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getMedecins() === $this) {
                $avi->setMedecins(null);
            }
        }

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs[] = $rdv;
            $rdv->setMedecins($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getMedecins() === $this) {
                $rdv->setMedecins(null);
            }
        }

        return $this;
    }


    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
    }

    public function getRoles()
    {
        //return ['ROLE_USER']; // utilisateur classique
       return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsername()
    {
    }

    public function getImage()//: ?string
    {
        return $this->Image;
    }

    public function setImage( $Image)//: self
    {
        $this->Image = $Image;

        return $this;
    }
}
