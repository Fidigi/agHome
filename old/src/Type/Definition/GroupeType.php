<?php
namespace AppContext\Type\Definition;

use AppContext\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use AppContext\Controllers\DossierUsagerController;
use AppContext\Models\GroupeAppartenanceModel;

class GroupeType extends ObjectType
{
    
    public function __construct()
    {
        $config = [
            'name' => 'Groupe',
            'description' => 'Groupe',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'label' => ['type' => Types::string(),'description' => 'Label'],
                    'structureId' => ['type' => Types::int(),'description' => 'Structure ID'],
                    'hidden' => ['type' => Types::int(),'description' => 'Hidden'],
                    'dossierUsager' => [
                        'type' => Types::listOf(Types::dossierUsager()),
                        'description' => 'Load group\'s DOS'
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
    
    public function resolveDossierUsager(GroupeAppartenanceModel $groupe)
    {
        return DossierUsagerController::findDossierUsagerByGroupe($groupe);
    }
}
