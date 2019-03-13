<?php
namespace App\GraphQL\Type\Definition;

use GraphQL\Type\Definition\InputObjectType;
use App\GraphQL\Type\Types;

class ListType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ListType',
            'fields' => [
                'id' => [
                    'type' => Types::id(),
                    'description' => 'Id'
                ],
                'value' => [
                    'type' => Types::nonNull(Types::string()),
                    'description' => 'Value'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
