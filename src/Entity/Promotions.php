<?php

namespace App\Entity;

use App\Repository\PromotionsRepository;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionsRepository::class)]
class Promotions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable:true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\Column]
    #[Assert\Range(
        notInRangeMessage: 'You must be between {{ min }}€ and {{ max }}€ to add promotion',
        min: 0,
        max: 100,
    )]
    private ?float $remise = null;

    #[ORM\OneToMany(mappedBy: 'promotions', targetEntity: Produit::class)]
    private Collection $Produits;

    public function __construct()
    {
        $this->Produits = new ArrayCollection();
        $this->date_start = new DateTime();
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->Produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->Produits->contains($produit)) {
            $this->Produits->add($produit);
            $produit->setPromotions($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->Produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getPromotions() === $this) {
                $produit->setPromotions(null);
            }
        }

        return $this;
    }
}
