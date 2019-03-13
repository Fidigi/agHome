<?php
namespace App\GraphQL\Type\Input;

use GraphQL\Type\Definition\InputObjectType;
use App\GraphQL\Type\Types;

class ListInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ListInput',
            'fields' => [
                'tag' => [
                    'type' => Types::string(),
                    'description' => 'Tag'
                ],
                'label' => [
                    'type' => Types::nonNull(Types::string()),
                    'description' => 'Label'
                ],
                'values' => [
                    'type' => Types::listOf(Types::listType()),
                    'description' => 'values'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
