<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;
use App\GraphQL\Mutation\MutationType;
use App\GraphQL\Queries\QueryType;
use App\GraphQL\Types\CategoryType;
use App\EMInit;
use GraphQL\Error\DebugFlag;
use Error;

class GraphQL
{
    static public function handle()
    {
        try {
            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                    ->setQuery(new QueryType(EMInit::$em))
                    ->setMutation(new MutationType(EMInit::$em))
            );

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            
            // error_log(print_r($result, true));
            if($result->toArray()['errors'] ?? false) {
                error_log(print_r($result->toArray()['errors'], true));
            }


            $output = $result->toArray();
        } catch (Throwable $e) {
            error_log($e);
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');

        return json_encode($output);
    }
}
