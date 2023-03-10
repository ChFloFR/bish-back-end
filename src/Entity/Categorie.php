<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isTrend = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'categories')]
    private Collection $produits;

    #[ORM\Column]
    private ?string $pathImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_image_trend = null;

    #[ORM\Column(nullable: true)]
    private ?bool $available = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
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

    public function isIsTrend(): ?bool
    {
        return $this->isTrend;
    }

    public function setIsTrend(bool $isTrend): self
    {
        $this->isTrend = $isTrend;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPathImage(): ?string
    {
        return $this->pathImage;
    }

    /**
     * @param string|null $pathImage
     */
    public function setPathImage(?string $pathImage): self
    {
        $this->pathImage = $pathImage;
        return $this;
    }


    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getPathImageTrend(): ?string
    {
        return $this->path_image_trend;
    }

    public function setPathImageTrend(?string $path_image_trend): self
    {
        $this->path_image_trend = $path_image_trend;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(?bool $available): self
    {
        $this->available = $available;

        return $this;
    }
}
