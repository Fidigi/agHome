<?php
namespace App\GraphQL\Type\Input;

use GraphQL\Type\Definition\InputObjectType;
use App\GraphQL\Type\Types;

class LoginInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'LoginInput',
            'fields' => [
                'username' => [
                    'type' => Types::nonNull(Types::string()),
                    'description' => 'Username'
                ],
                'password' => [
                    'type' => Types::nonNull(Types::string()),
                    'description' => 'Password'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
