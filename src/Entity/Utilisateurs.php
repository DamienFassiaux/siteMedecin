<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 * @UniqueEntity(
 *      fields = {"email"},
 *      message = "Un compte est déjà existant à cette adresse Email !!"
 * )
 */
class Utilisateurs implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Veuillez renseigner un nom ! "
     * )
     *  *  @Assert\NotBlank(
     *      message = "Veuillez renseigner un numéro de téléphone! "
     * )
     * @Assert\Length(
     *      min=2,
     *      max=30,
     *      minMessage = "Nom trop court",
     *      maxMessage = "Nom trop long"
     * 
     * )
     *  
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(
     *      message = "Veuillez renseigner un prenom ! "
     * )
     * @Assert\Length(
     *      min=2,
     *      max=30,
     *      minMessage = "Prenom trop court",
     *      maxMessage = "Prenom trop long"
     * 
     * )

     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\length(
     *      min=10,
     *      max=10,
     *      exactMessage = "numéro incorrect"
     *    
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Veuillez renseigner une adresse ! "
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *      message = "Veuillez renseigner un code postale! "
     * )
     * @Assert\length(
     *      min=5,
     *      max=5,
     *      exactMessage = "code postale incorrect"
     *    
     * )
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(
     *      message = "Veuillez renseigner une ville ! "
     * )
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(
     *      message = "Veuillez renseigner une adresse mail ! "
     * )
     * @Assert\Email(
     *      message = "veuillez saisir une adresse Email Valide ! "
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(
     *      message = "Veuillez renseigner un mot de passe ! "
     * )
     *@Assert\EqualTo( propertyPath = "confirm_password", message = "Les mots de passes ne correspondent pas !",
     *                                                     
     * )
     * 
     */
    private $password;

    /**
     * @Assert\NotBlank(
     *      message = "Veuillez confirmer voitre mot de passe ! "
     * )
     * @Assert\EqualTo( propertyPath = "password", message = "Les mots de passes ne correspondent pas !",
     *                                                   
     * )
     */

    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="utilisateurs", orphanRemoval=true)
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="utilisateurs", orphanRemoval=true)
     */
    private $rdvs;

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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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
            $avi->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUtilisateurs() === $this) {
                $avi->setUtilisateurs(null);
            }
        }

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
            $rdv->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getUtilisateurs() === $this) {
                $rdv->setUtilisateurs(null);
            }
        }

        return $this;
    }


    public function eraseCredentials()
    {
    }
    // Renvoi la chaine de caractère non encodé que l'utilisateur a saisi, qui est utilisé à l'origine pour, encoder le mot de passe

    public function getSalt()
    {
    }



    // Renvoi les rôles accordés à l'utilisateur

    public function getRoles()
    {
    }
    public function getUsername()
    {
    }
}
