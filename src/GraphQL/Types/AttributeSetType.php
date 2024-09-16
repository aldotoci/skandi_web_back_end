<?php

/*
    AttributeSet Model Example
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

*/

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeSetType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'AttributeSet',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                ],
                'name' => [
                    'type' => Type::string(),
                ],
                'type' => [
                    'type' => Type::string(),
                ],
                'items' => [
                    'type' => Type::listOf(AttributeType::getInstance()),
                ],
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
            self::$instance = new AttributeSetType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}