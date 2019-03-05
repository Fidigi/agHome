<?php
namespace App\GraphQL\Type\Input;

use GraphQL\Type\Definition\InputObjectType;
use App\GraphQL\Type\Types;

class UserUuidInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'UserUuidInput',
            'fields' => [
                'user_uuid' => [
                    'type' => Types::nonNull(Types::string()),
                    'description' => 'User Uuid'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
