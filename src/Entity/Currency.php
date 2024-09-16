<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "currencies")]
class Currency
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string")]
    private string $label;

    #[ORM\Column(type: "string")]
    private string $symbol;

    #[ORM\OneToMany(targetEntity: "Price", mappedBy: "currency", cascade: ["persist", "remove"])]
    private Collection $prices;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setCurrency($this);
        }
        return $this;
    }

    public function removePrice(?Price $price): self
    {
        if ($this->prices->removeElement($price)) {
            if ($price->getCurrency() === $this) {
                $price->setCurrency(null);
            }
        }
        return $this;
    }
}