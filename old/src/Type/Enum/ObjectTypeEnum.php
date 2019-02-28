<?php
namespace AppContext\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class ObjectTypeEnum extends EnumType
{
    public function __construct()
    {
        $config = [
            'values' => [
                'user' => 'Users',
                'groupe' => 'GroupeAppartenance',
                'dossier_usager' => 'DossierUsager',
                'structure' => 'Structure'
            ]
        ];

        parent::__construct($config);
    }
}
