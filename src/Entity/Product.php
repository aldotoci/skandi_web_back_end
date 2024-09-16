<?php
/*
    Product Model Example
    {
        "id": "huarache-x-stussy-le",
        "name": "Nike Air Huarache Le",
        "inStock": true,
        "gallery": [
          "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087",
          "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087",
          "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087",
          "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087",
          "https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087"
        ],
        "description": "<p>Great sneakers for everyday use!</p>",
        "category": "clothes",
        "attributes": [
          {
            "id": "Size",
            "items": [
              {
                "displayValue": "40",
                "value": "40",
                "id": "40",
                "__typename": "Attribute"
              },
              {
                "displayValue": "41",
                "value": "41",
                "id": "41",
                "__typename": "Attribute"
              },
              {
                "displayValue": "42",
                "value": "42",
                "id": "42",
                "__typename": "Attribute"
              },
              {
                "displayValue": "43",
                "value": "43",
                "id": "43",
                "__typename": "Attribute"
              }
            ],
            "name": "Size",
            "type": "text",
            "__typename": "AttributeSet"
          }
        ],
        "prices": [
          {
            "amount": 144.69,
            "currency": {
              "label": "USD",
              "symbol": "$",
              "__typename": "Currency"
            },
            "__typename": "Price"
          }
        ],
        "brand": "Nike x Stussy",
        "__typename": "Product"
      }

 */


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\EMInit;

use function PHPSTORM_META\type;

#[ORM\Entity]
#[ORM\Table(name: "products")]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "boolean")]
    private bool $inStock;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\ManyToOne(targetEntity: "Category", inversedBy: "products")]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\Column(type: "string")]
    private string $brand;

    #[ORM\Column(type: "json")]
    private array $gallery;

    #[ORM\OneToMany(targetEntity: "AttributeSet", mappedBy: "product", cascade: ["persist", "remove"])]
    private Collection $attributes;

    #[ORM\OneToMany(targetEntity: "Price", mappedBy: "product", cascade: ["persist", "remove"])]
    private Collection $prices;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();

        $this->prices = new ArrayCollection();

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

    public function getInStock(): bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): self
    {
        $this->inStock = $inStock;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getGallery(): array
    {
        return $this->gallery;
    }

    public function setGallery(array $gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(AttributeSet $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setProduct($this);
        }
        return $this;
    }

    public function removeAttribute(AttributeSet $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            if ($attribute->getProduct() === $this) {
                $attribute->setProduct(null);
            }
        }
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
            $price->setProduct($this);
        }
        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->removeElement($price)) {
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }
        return $this;
    }

    public function populateFromJson($product_json){
        $em = EMInit::$em;

        #Checking if the catregory exists
        $category = $em->getRepository(Category::class)->findOneBy(['name' => $product_json['category']]);
        if (!$category) {
            $category = new Category;
            $category->setName($product_json['category']);
            $em->persist($category);
            $em->flush();
        }

        $this->setId($product_json['id']);
        $this->setName($product_json['name']);
        $this->setInStock($product_json['inStock']);
        $this->setDescription($product_json['description']);
        $this->setCategory($category);
        $this->setBrand($product_json['brand']);
        $this->setGallery($product_json['gallery']);

        $em->persist($this);

        foreach ($product_json['attributes'] as $attributeSetData) {
            $attributeSet = new AttributeSet();
            $attributeSet->setId($attributeSetData['id']);
            $attributeSet->setName($attributeSetData['name']);
            $attributeSet->setType($attributeSetData['type']);
            $attributeSet->setProduct($this);

            $em->persist($attributeSet);

            foreach ($attributeSetData['items'] as $attributeData) {
                $attribute = $em->getRepository(Attribute::class)->findOneBy(['id' => $attributeData['id']]);
                if(!$attribute){
                    $attribute = new Attribute();
                    $attribute->setId($attributeData['id']);
                    $attribute->setDisplayValue($attributeData['displayValue']);
                    $attribute->setValue($attributeData['value']);
                }
                $attribute->setAttributeSets($attributeSet);
                $em->persist($attribute);
                $em->flush();
            }
            $em->flush();
        }

        foreach ($product_json['prices'] as $priceData) {
            $price = new Price();
            $price->setAmount($priceData['amount']);

            $currency = $em->getRepository(Currency::class)->findOneBy(['label' => $priceData['currency']['label']]);
            if (!$currency) {
                $currency = new Currency();
                $currency->setLabel($priceData['currency']['label']);
                $currency->setSymbol($priceData['currency']['symbol']);
                $em->persist($currency);
            }

            $price->setCurrency($currency);
            $price->setProduct($this);

            $em->persist($price);
            $em->flush();
        }
    }

    public function flush(){
        $em = EMInit::$em;
        $em->flush();
    }


    public function getAssociativeArray(){
        $product = [];
        $product['id'] = $this->getId();
        $product['name'] = $this->getName();
        $product['inStock'] = $this->getInStock();
        $product['description'] = $this->getDescription();
        $product['category'] = $this->getCategory()->getName();
        $product['brand'] = $this->getBrand();
        $product['gallery'] = $this->getGallery();


        $attributes = [];
        // foreach ($this->getAttributes() as $attributeSet) {
        //     if ($attributeSet === null) {
        //         continue;
        //     }

        //     $attributeSetData = [];

        //     if ($attributeSet->getName() == 'Size')

        //     error_log($attributeSet->getName());

        //     $attributeSetData['id'] = $attributeSet->getId();
        //     $attributeSetData['name'] = $attributeSet->getName();
        //     $attributeSetData['type'] = $attributeSet->getType();

        //     $items = [];
        //     foreach ($attributeSet->getItems() as $attribute) {
        //         if ($attribute === null) {
        //             continue;
        //         }

        //         $items[] = [
        //             'displayValue' => $attribute->getDisplayValue(),
        //             'value' => $attribute->getValue(),
        //             'id' => $attribute->getId(),
        //             '__typename' => 'Attribute'
        //         ];
        //     }
        //     $attributeSetData['items'] = $items;
        //     $attributeSetData['__typename'] = 'AttributeSet';
        //     $attributes[] = $attributeSetData;
        // }
        $product['attributes'] = $attributes;

        $prices = [];
        foreach ($this->getPrices() as $price) {
            if ($price === null) {
                continue;
            }

            $priceData = [];
            $priceData['amount'] = $price->getAmount();
            $priceData['currency'] = [
                'label' => $price->getCurrency()->getLabel(),
                'symbol' => $price->getCurrency()->getSymbol(),
                '__typename' => 'Currency'
            ];
            $priceData['__typename'] = 'Price';
            $prices[] = $priceData;
        }
        $product['prices'] = $prices;

        return $product;
    }    

}