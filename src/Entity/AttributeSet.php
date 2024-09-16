<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "attribute_sets")]
class AttributeSet
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private string $OID;

    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "string")]
    private string $type;

    #[ORM\ManyToOne(targetEntity: "Product", inversedBy: "attributes")]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\ManyToMany(targetEntity: "Attribute", mappedBy: "attributeSet", cascade: ["persist", "remove"])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Attribute $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setAttributeSets($this);
        }
        return $this;
    }

    public function removeItem(Attribute $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getAttributeSets() === $this) {
                $item->setAttributeSets(null);
            }
        }
        return $this;
    }
}