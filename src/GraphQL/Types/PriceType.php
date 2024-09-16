<?php

/*
    PriceType model example
    {
        "amount": 144.69,
        "currency": {
            "label": "USD",
            "symbol": "$",
            "__typename": "Currency"
        },
        "__typename": "Price"
    }
*/

namespace App\GraphQL\Types;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'Price',
            'fields' => [
                'amount' => [
                    'type' => Type::float(),
                ],
                'currency' => [
                    'type' => CurrencyType::getInstance(),
                ],
            ],
        ];

        parent::__construct($config);
    }

    // Method to get the single instance of PriceType
    public static function getInstance()
    {
        // Check if an instance already exists
        if (self::$instance === null) {
            // Create a new instance if none exists
            self::$instance = new PriceType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}