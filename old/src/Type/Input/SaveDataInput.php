<?php
namespace AppContext\Type\Input;

use GraphQL\Type\Definition\InputObjectType;
use AppContext\Types;

class SaveDataInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'SaveDataInput',
            'fields' => [
                'type' => [
                    'type' => Types::nonNull(Types::objectTypeEnum()),
                    'description' => 'Type of object to save'
                ],
                'data' => [
                    'type' => Types::listOf(Types::mixed()),
                    'description' => 'Data to save'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
