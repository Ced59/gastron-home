<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
{
    public function __toString()
    {
        return $this->companyName;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="restaurant", cascade={"persist", "remove"})
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity=CategorieRestaurant::class, mappedBy="restaurant")
     * @ORM\JoinTable(name="categorie_restaurant_restaurant",
     *      joinColumns={@ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="categorie_restaurant_id", referencedColumnName="id")}
     *      )
     */
    private $categorieRestaurants;

    /**
     * @ORM\OneToMany(targetEntity=Plats::class, mappedBy="restaurant")
     */
    private $plats;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="restaurant")
     */
    private $commandes;

    public function __construct()
    {
        $this->categorieRestaurants = new ArrayCollection();
        $this->plats = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setRestaurant(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getRestaurant() !== $this) {
            $utilisateur->setRestaurant($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|CategorieRestaurant[]
     */
    public function getCategorieRestaurants(): Collection
    {
        return $this->categorieRestaurants;
    }

    public function addCategorieRestaurant(CategorieRestaurant $categorieRestaurant): self
    {
        if (!$this->categorieRestaurants->contains($categorieRestaurant)) {
            $this->categorieRestaurants[] = $categorieRestaurant;
            $categorieRestaurant->addRestaurant($this);
        }

        return $this;
    }

    public function removeCategorieRestaurant(CategorieRestaurant $categorieRestaurant): self
    {
        if ($this->categorieRestaurants->removeElement($categorieRestaurant)) {
            $categorieRestaurant->removeRestaurant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Plats[]
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plats $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setRestaurant($this);
        }

        return $this;
    }

    public function removePlat(Plats $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getRestaurant() === $this) {
                $plat->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setRestaurant($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getRestaurant() === $this) {
                $commande->setRestaurant(null);
            }
        }

        return $this;
    }
}
