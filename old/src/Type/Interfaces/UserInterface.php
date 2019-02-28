<?php
namespace AppContext\Type\Interfaces;

use AppContext\Types;
use GraphQL\Type\Definition\InterfaceType;

class UserInterface extends InterfaceType
{
    public function __construct()
    {
        $config = [
            'name' => 'Utilisateur',
            'description' => 'Utilisateur',
            'fields' => [
                'proId' => Types::id()
            ],
            'resolveType' => [$this, 'resolveNodeType']
        ];
        parent::__construct($config);
    }
    
    /**
     * Return good instance of object
     * @param object $object
     */
    public function resolveNodeType($object)
    {
        return Types::user();
    }
    
}