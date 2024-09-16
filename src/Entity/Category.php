<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "categories")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\OneToMany(targetEntity: "Product", mappedBy: "category")]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }
        return $this;
    }

    public function populateFromJson($json)
    {
        $this->setName($json['name']);

        return $this;
    }

    public function getAssociativeArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}