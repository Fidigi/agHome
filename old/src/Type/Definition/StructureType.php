<?php
namespace AppContext\Type\Definition;

use AppContext\Controllers\UsersController;
use AppContext\Models\StructureModel;
use AppContext\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use AppContext\Controllers\GroupeController;

/**
 * Class StoryType
 * @package GraphQL\Examples\Social\Type
 */
class StructureType extends ObjectType
{

    public function __construct()
    {
        $config = [
            'name' => 'Structure',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'label' => ['type' => Types::string(),'description' => 'Label'],
                    'hidden' => ['type' => Types::int(),'description' => 'TODO'],
                    'name' => ['type' => Types::string(),'description' => 'Name'],
                    'address' => ['type' => Types::string(),'description' => 'Address'],
                    'address2' => ['type' => Types::string(),'description' => 'Address 2'],
                    'zipcode' => ['type' => Types::string(),'description' => 'Zipcode'],
                    'city' => ['type' => Types::string(),'description' => 'City'],
                    'logo' => ['type' => Types::string(),'description' => 'Logo'],
                    'installationDate' => ['type' => Types::string(),'description' => 'Installation date'],
                    'finessNumber' => ['type' => Types::string(),'description' => 'Finess number'],
                    'sirenNumber' => ['type' => Types::string(),'description' => 'Siren number'],
                    'siretNumber' => ['type' => Types::string(),'description' => 'Siret number'],
                    'type' => ['type' => Types::string(),'description' => 'Type'],
                    'phone' => ['type' => Types::string(),'description' => 'Phone'],
                    'fax' => ['type' => Types::string(),'description' => 'Fax'],
                    'email' => ['type' => Types::string(),'description' => 'Email'],
                    'website' => ['type' => Types::string(),'description' => 'Website'],
                    'homeinformation' => ['type' => Types::string(),'description' => 'TODO'],
                    'additionalData' => ['type' => Types::string(),'description' => 'TODO'],
                    'comment' => ['type' => Types::string(),'description' => 'Comment'],
                    'users' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Load structure\'s users'
                    ], 
                    'groupe' => [
                        'type' => Types::listOf(Types::groupe()),
                        'description' => 'Load structure\'s group'
                    ]
                ];
            },
            'resolveField' => function($value, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($value, $args, $context, $info);
                } else {
                    return $value->{$info->fieldName};
                }
            }
        ];
        parent::__construct($config);
    }

    public function resolveUsers(StructureModel $structure)
    {
        return UsersController::findUsersByStructure($structure);
    }
    
    public function resolveGroupe(StructureModel $structure)
    {
        return GroupeController::findGroupeByStructure($structure);
    }
}
