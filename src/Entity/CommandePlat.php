<?php

namespace App\Entity;

use App\Repository\CommandePlatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandePlatRepository::class)
 */
class CommandePlat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=commande::class, inversedBy="commandePlats")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Plats::class, inversedBy="commandePlats")
     */
    private $plats;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPlats(): ?Plats
    {
        return $this->plats;
    }

    public function setPlats(?Plats $plats): self
    {
        $this->plats = $plats;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
