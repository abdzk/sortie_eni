<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email existe déjà')]
#[UniqueEntity(fields: ['pseudo'], message: 'Ce pseudo existe déjà')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    /**
     * @Assert\Length(max=180, maxMessage="L'email doit contenir 180 caractères maximum")
     * @Assert\NotBlank(message="Entrez votre adresse mail!")
     */
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private array $roles = [];

    #[ORM\Column(length: 180)]
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    /**
     * @Assert\Length(max=50,
     *     maxMessage="Le pseudo doit contenir 50 caractères maximum")
     *  @Assert\NotBlank(message="Entrez votre nom")
     */
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    /**
     * @Assert\Length(max=50,
     *     maxMessage="Le pseudo doit contenir 50 caractères maximum")
     *  @Assert\NotBlank(message="Entrez votre prénom")
     */
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]

    private ?int $telephone = null;

    #[ORM\Column(length: 180, unique: true)]
    /**
     * @Assert\Length(min=2, max=180, minMessage="Le pseudo doit contenir 2 caractères minimum",
     *     maxMessage="Le pseudo doit contenir 180 caractères maximum")
     *  @Assert\NotBlank(message="Entrez votre pseudo")
     */
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?bool $administrateur = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Campus $campus = null;

    #[ORM\ManyToMany(targetEntity: Sortie::class, inversedBy: 'users')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Sortie::class)]
    private Collection $sorties;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }



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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return ($this->administrateur) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }



    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAdministrateur(): ?string
    {
        return $this->administrateur;
    }

    public function setAdministrateur(string $administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Sortie $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(Sortie $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSortie(Sortie $sortie): self
    {
        if (!$this->sorties->contains($sortie)) {
            $this->sorties->add($sortie);
            $sortie->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSortie(Sortie $sortie): self
    {
        $this->sorties->removeElement($sortie);

        return $this;
    }
   
}
