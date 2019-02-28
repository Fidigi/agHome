<?php
namespace AppContext\Type;

use AppContext\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use AppContext\AppContext;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                // List of mutations:
                'saveData' => [
                    'args' => [
                        'data' => Types::nonNull(Types::saveDataInput())
                    ],
                    'type' => new ObjectType([
                        'name' => 'SaveDataOutput',
                        'fields' => [
                            'status' => ['type' => Types::string()],
                            'message' => ['type' => Types::string()]
                        ]
                    ]),
                    'resolve' => function ($root, $args, AppContext $context, ResolveInfo $info) {
                        var_dump($args);
                        $data = array();
                        $data['status'] = '200';
                        $data['message'] = 'Yes we can!';
                        return $data;
                    }
                ],
                'sum' => [
                    'type' => Types::int(),
                    'args' => [
                        'x' => ['type' => Types::int()],
                        'y' => ['type' => Types::int()],
                    ],
                    'resolve' => function ($root, $args) {
                        return $args['x'] + $args['y'];
                    },
                ],
                // ... other mutations
            ]
        ];
        parent::__construct($config);
    }
}
