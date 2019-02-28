<?php
namespace AppContext\Type;

use AppContext\AppContext;
use AppContext\Types;
use AppContext\Controllers\UsersController;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'users' => [
                    'type' => Types::listOf(Types::user()),
                    'description' => 'Return users (priority criterion \'id\')',
                    'args' => [
                        'id' => Types::id(),
                        'type' => Types::userTypeEnum(),
                        'withDeleted' => [
                            'type' => Types::boolean(),
                            'defaultValue' => false
                        ],
                        'limit' => [
                            'type' => Types::int(),
                            'description' => 'Limit number of returns',
                            'defaultValue' => 10
                        ]
                    ]
                ],
                'viewer' => [
                    'type' => Types::user(),
                    'description' => 'Represents currently logged-in user (for the sake of example - simply returns user with id == 1)'
                ],
                'hello' => Type::string()
            ],
            'resolveField' => function($val, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($val, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function users($rootValue, $args, AppContext $context)
    {
        return UsersController::listAction($rootValue, $args, $context);
    }

    public function viewer($rootValue, $args, AppContext $context)
    {
        return $context->viewer;
    }
    
    public function hello()
    {
        return 'Your graphql-php endpoint is ready! Use GraphiQL to browse API';
    }
}
