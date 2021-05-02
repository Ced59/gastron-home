<?php

namespace App\Entity;

use App\Repository\PlatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlatsRepository::class)
 */
class Plats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriePlats::class, inversedBy="plats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriePlats;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="plats")
     * @ORM\JoinColumn(nullable=true)
     */
    private $restaurant;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Votre stock doit être positif")
     */
    private $qte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_file_plat;

    /**
     * @ORM\OneToMany(targetEntity=CommandePlat::class, mappedBy="plats")
     */
    private $commandePlats;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->commandePlats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategoriePlats(): ?CategoriePlats
    {
        return $this->categoriePlats;
    }

    public function setCategoriePlats(?CategoriePlats $categoriePlats): self
    {
        $this->categoriePlats = $categoriePlats;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getImageFilePlat(): ?string
    {
        return $this->image_file_plat;
    }

    public function setImageFilePlat(?string $image_file_plat): self
    {
        $this->image_file_plat = $image_file_plat;

        return $this;
    }

    /**
     * @return Collection|CommandePlat[]
     */
    public function getCommandePlats(): Collection
    {
        return $this->commandePlats;
    }

    public function addCommandePlat(CommandePlat $commandePlat): self
    {
        if (!$this->commandePlats->contains($commandePlat)) {
            $this->commandePlats[] = $commandePlat;
            $commandePlat->setPlats($this);
        }

        return $this;
    }

    public function removeCommandePlat(CommandePlat $commandePlat): self
    {
        if ($this->commandePlats->removeElement($commandePlat)) {
            // set the owning side to null (unless already changed)
            if ($commandePlat->getPlats() === $this) {
                $commandePlat->setPlats(null);
            }
        }

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

    public function __call($name, $arguments)
    {
        return $this->name;
    }


}
