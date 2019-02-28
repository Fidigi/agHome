<?php
namespace AppContext\Type\Definition;

use AppContext\Controllers\StructureController;
use AppContext\Models\UsersModel;
use AppContext\Types;
use AppContext\Type\Interfaces\UserInterface;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class UserType extends ObjectType
{
    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_USAGER = 'usager';
    const USER_TYPE_EXTERNE = 'externe';
    const USER_TYPE_INTERNE = 'interne';
    
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'User',
            'fields' => function() {
                return [
                    'proId' => Types::id(),
                    'proLogin' => ['type' => Types::string(),'description' => 'Login'],
                    'proPassword' => ['type' => Types::string(),'description' => 'Password'],
                    'proNom' => ['type' => Types::string(),'description' => 'Name'],
                    'proPrenom' => ['type' => Types::string(),'description' => 'Firstname'],
                    'proFonction' => ['type' => Types::string(),'description' => 'Function'],
                    'proMail' => ['type' => Types::email(),'description' => 'Email'],
                    'phone' => ['type' => Types::string(),'description' => 'Phone'],
                    'identificationNumber' => ['type' => Types::string(),'description' => 'TODO'],
                    'vidalToken' => ['type' => Types::string(),'description' => 'Token Vidal'],
                    'proRightsDossier' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatut' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsIdentite' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsFichePerso' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsFicheAutres' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsEvent' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsRv' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsMdoc' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsGdoc' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsDoc' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsSendDoc' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsAlerte' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsActivite' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsDemographique' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsEvenement' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsAnnuaire' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsForm' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsMail' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsInfoStruct' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsPlanning' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsFicheAnnuaire' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsConsultation' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsConsultationAutres' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsPrescription' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsOrdonnance' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsRcp' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsRcpPatient' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsUnitebilan' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsHideIntervenantReferent' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsAaBilans' => ['type' => Types::int(),'description' => 'TODO'],
                    'proRightsStatsAaUb' => ['type' => Types::int(),'description' => 'TODO'],
                    'domaine' => ['type' => Types::int(),'description' => 'TODO'],
                    'admin' => ['type' => Types::int(),'description' => 'Is admin'],
                    'deleted' => ['type' => Types::int(),'description' => 'Is deleted'],
                    'droitTransfert' => ['type' => Types::int(),'description' => 'TODO'],
                    'droitProfil' => ['type' => Types::int(),'description' => 'TODO'],
                    'proColor' => ['type' => Types::string(),'description' => 'TODO'],
                    'colors' => ['type' => Types::string(),'description' => 'TODO'],
                    'profilId' => ['type' => Types::int(),'description' => 'TODO'],
                    'domaineInter' => ['type' => Types::string(),'description' => 'TODO'],
                    'verified' => ['type' => Types::int(),'description' => 'TODO'],
                    'code' => ['type' => Types::string(),'description' => 'TODO'],
                    'codeDate' => ['type' => Types::string(),'description' => 'TODO'],
                    'robjectId' => ['type' => Types::string(),'description' => 'TODO'],
                    'accessLimited' => ['type' => Types::int(),'description' => 'TODO'],
                    'folderModifiedNotification' => ['type' => Types::int(),'description' => 'TODO'],
                    'params' => ['type' => Types::string(),'description' => 'TODO'],
                    'additionalData' => ['type' => Types::string(),'description' => 'TODO'],
                    'beneficiaryfolderId' => ['type' => Types::int(),'description' => 'TODO'],
                    'secretQuestionId' => ['type' => Types::int(),'description' => 'TODO'],
                    'secretAnswer' => ['type' => Types::string(),'description' => 'TODO'],
                    'lastConnection' => ['type' => Types::string(),'description' => 'TODO'],
                    'isDoctor' => ['type' => Types::int(),'description' => 'TODO'],
                    'isFree' => ['type' => Types::int(),'description' => 'TODO'],
                    'lastPwModified' => ['type' => Types::string(),'description' => 'TODO'],
                    'limitedToIp' => ['type' => Types::string(),'description' => 'TODO'],
                    'charterAccepted' => ['type' => Types::string(),'description' => 'TODO'],
                    'structures' => [
                        'type' => Types::listOf(Types::structure()),
                        'description' => 'Load user\'s structures'
                    ]
                ];
            },
            'interfaces' => [
                new UserInterface()
            ],
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

    public function resolveStructures(UsersModel $user)
    {
        return StructureController::findStructureByUser($user);
    }
}
