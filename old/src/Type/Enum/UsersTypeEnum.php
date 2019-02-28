<?php
namespace AppContext\Type\Enum;

use AppContext\Type\Definition\UserType;
use GraphQL\Type\Definition\EnumType;

class UsersTypeEnum extends EnumType
{
    public function __construct()
    {
        $config = [
            // Note: 'name' option is not needed in this form - it will be inferred from className
            'values' => [
                'admin' => UserType::USER_TYPE_ADMIN,
                'usager' => UserType::USER_TYPE_USAGER,
                'externe' => UserType::USER_TYPE_EXTERNE,
                'interne' => UserType::USER_TYPE_INTERNE
            ]
        ];

        parent::__construct($config);
    }
}
