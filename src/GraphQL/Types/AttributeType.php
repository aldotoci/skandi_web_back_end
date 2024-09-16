<?php

/*
    AttributeType Model Example
    {
        "displayValue": "40",
        "value": "40",
        "id": "40",
        "__typename": "Attribute"
    }

*/

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class AttributeType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'Attribute',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                ],
                'value' => [
                    'type' => Type::string(),
                ],
                'displayValue' => [
                    'type' => Type::string(),
                ],
            ],
        ];

        parent::__construct($config);
    }

    // Method to get the single instance of AttributeSetType
    public static function getInstance()
    {
        // Check if an instance already exists
        if (self::$instance === null) {
            // Create a new instance if none exists
            self::$instance = new AttributeType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}