<?php

/*
    CurrencyType model example
    {
        "label": "USD",
        "symbol": "$",
        "__typename": "Currency"
    }
*/

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'Currency',
            'fields' => [
                'label' => [
                    'type' => Type::string(),
                ],
                'symbol' => [
                    'type' => Type::string(),
                ],
            ],
        ];

        parent::__construct($config);
    }

    // Method to get the single instance of CurrencyType
    public static function getInstance()
    {
        // Check if an instance already exists
        if (self::$instance === null) {
            // Create a new instance if none exists
            self::$instance = new CurrencyType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}