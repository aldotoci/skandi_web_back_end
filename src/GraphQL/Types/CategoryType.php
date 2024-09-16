<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType
{
    private static $instance = null;

    public function __construct()
    {
        $config = [
            'name' => 'Category',
            'fields' => [
                'id' => [
                    'type' => Type::int(),
                ],
                'name' => [
                    'type' => Type::string(),
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
            self::$instance = new CategoryType();
        }

        // Return the existing or new instance
        return self::$instance;
    }
}