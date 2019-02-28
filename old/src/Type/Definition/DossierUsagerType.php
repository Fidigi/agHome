<?php
namespace AppContext\Type\Definition;

use AppContext\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class DossierUsagerType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'DossierUsager',
            'description' => 'Dossier usager',
            'fields' => function() {
                return [
                    'dosId' => Types::id(),
                    'civilite' => ['type' => Types::string(),'description' => 'Civilite'],
                    'nom' => ['type' => Types::string(),'description' => 'Nom'],
                    'prenom' => ['type' => Types::string(),'description' => 'Prenom'],
                    'nomJf' => ['type' => Types::string(),'description' => 'Nom patronique'],
                    'dateNaissance' => ['type' => Types::string(),'description' => 'Date de naissance'],
                    'createdAt' => ['type' => Types::string(),'description' => 'TODO'],
                    'createdBy' => ['type' => Types::int(),'description' => 'TODO'],
                    'updatedAt' => ['type' => Types::string(),'description' => 'TODO'],
                    'updatedBy' => ['type' => Types::int(),'description' => 'TODO'],
                    'ideId' => ['type' => Types::int(),'description' => 'TODO'],
                    'dosEvaluationProblematique' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosAttenteMotif' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosSuiviDateDebut' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosSuiviDateFin' => ['type' => Types::string(),'description' => 'TODO'],
                    'referentExterne' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosSuiviCotorep' => ['type' => Types::int(),'description' => 'TODO'],
                    'dosSuiviCotorepDate' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosFermeMotif' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosFermeReorientation' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosFermeDate' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosFermeObservation' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosOrigine' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosNotes' => ['type' => Types::string(),'description' => 'TODO'],
                    'dosColor' => ['type' => Types::string(),'description' => 'TODO'],
                    'isLastVersion' => ['type' => Types::int(),'description' => 'TODO'],
                    'deleted' => ['type' => Types::int(),'description' => 'TODO'],
                    'decede' => ['type' => Types::int(),'description' => 'TODO'],
                    'decedeDate' => ['type' => Types::int(),'description' => 'TODO']
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
}
