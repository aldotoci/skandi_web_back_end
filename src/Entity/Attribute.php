<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "attributes")]
class Attribute
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private string $OID;

    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $displayValue;

    #[ORM\Column(type: "string")]
    private string $value;

    #[ORM\ManyToMany(targetEntity: "AttributeSet", inversedBy: "items")]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $attributeSets;

    public function __construct()
    {
        $this->attributeSets = new ArrayCollection();
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

    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    public function setDisplayValue(string $displayValue): self
    {
        $this->displayValue = $displayValue;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getAttributeSets(): Collection
    {
        return $this->attributeSets;
    }

    public function setAttributeSets(?AttributeSet $attributeSet): self
    {
        $this->attributeSets->add($attributeSet);
        return $this;
    }
}