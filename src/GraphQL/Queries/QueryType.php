<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Entity\Category;
use App\GraphQL\Types\CategoryType;
use App\Entity\Product;
use App\GraphQL\Types\ProductType;

use function PHPSTORM_META\type;

class QueryType extends ObjectType{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
        $config = [
            'name' => 'Query',
            'fields' => [
                'category' => [
                    'type' => CategoryType::getInstance(),
                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],
                    'resolve' => function ($rootValue, array $args) {
                        error_log($args['id']);
                        $category = $this->em->getRepository(Category::class)->find($args['id']);
                        
                        if (empty($category)) {
                            return null;
                        }
                        $to_return = $category->getAssociativeArray();
                        return $to_return;
                    },
                ],
                'categories' => [
                    'type' => Type::listOf(CategoryType::getInstance()),
                    'resolve' => function ($rootValue, array $args) {
                        $categories = $this->em->getRepository(Category::class)->findAll();
                        $categories = array_map(fn($category) => $category->getAssociativeArray(), $categories);
                        return $categories;
                    },
                ],
                'product' => [
                    'type' => ProductType::getInstance(),
                    'args' => [
                        'id' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($rootValue, array $args) {
                        $product = $this->em->getRepository(Product::class)->find($args['id']);
                        return $product->getAssociativeArray();
                    },
                ],
                'products' => [
                    'type' => Type::listOf(ProductType::getInstance()),
                    'resolve' => function ($rootValue, array $args) {
                        $products = $this->em->getRepository(Product::class)->findAll();
                        
                        $products = array_map(fn($product) => $product->getAssociativeArray(), $products);
                        
                        

                        return $products;
                    },
                ],
                'productByCategory' => [
                    'type' => Type::listOf(ProductType::getInstance()),
                    'args' => [
                        'category' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($rootValue, array $args) {
                        $products = $this->em->getRepository(Product::class)->findBy(['category' => $args['category']]);
                        return $products;
                    },
                ]
            ],
        ];

        parent::__construct($config);
    }
}