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

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'Product',
            'fields' => [
                'id' => Type::string(),
                'name' => Type::string(),
                'inStock' => Type::boolean(),
                'gallery' => Type::listOf(Type::string()),
                'description' => Type::string(),
                'category' => Type::string(),
                'attributes' => Type::listOf(AttributeSetType::getInstance()),
                'prices' => Type::listOf(PriceType::getInstance()),
                'brand' => Type::string(),           
            ],
        ];

        parent::__construct($config);
    }

    // Method to get the single instance of CategoryType
    public static function getInstance()
    {
        // Check if an instance already exists
        if (self::$instance === null) {
            // Create a new instance if none exists
            self::$instance = new ProductType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}