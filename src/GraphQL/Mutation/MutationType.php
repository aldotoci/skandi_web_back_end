<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Entity\Category;
use GraphQL\Type\Schema;
use App\GraphQL\Types\CategoryType;
use App\Entity\Product;
use App\GraphQL\Types\ProductType;

class MutationType extends ObjectType
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;

        $config = [
            'name' => 'Mutation',
            'fields' => [
                'createCategory' => [
                    'type' => CategoryType::getInstance(),
                    'args' => [
                        'name' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($rootValue, array $args) {
                        $category = new Category();
                        $category->setName($args['name']); 
                        $this->em->persist($category);
                        $this->em->flush();
                        return $category->getAssociativeArray();
                    },
                ],
                'createProduct' => [
                    'type' => ProductType::getInstance(),
                    'args' => [
                        'data' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($rootValue, array $args) {
                        $product = new Product();
                        $product->populateFromJson(json_decode($args['data']));
                        $this->em->persist($product);
                        $this->em->flush();
                    },
                ]
            ],
        ];

        parent::__construct($config);
    }
}