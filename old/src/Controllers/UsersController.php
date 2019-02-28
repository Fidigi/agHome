<?php
namespace AppContext\Controllers;

use AppContext\Models\UsersModel;
use AppContext\Models\UsersCollection;
use AppContext\AppContext;

class UsersController 
{
    /**
     * return list of users
     * @param $rootValue
     * @param $args
     * @param AppContext $context
     * @return array
     */
    public static function listAction($rootValue, $args, AppContext $context) {
        $users = null;
        $returnUsers = null;
        //Si recherche par ID, pas d'application des autres criteres
        if(isset($args['id'])){
            return UsersModel::loadByProId($args['id']);
        }
        //Gestion du cas de demande d'un type
        if(isset($args['type'])){
            switch ($args['type']) {
                case 'admin':
                    $returnUsers = $args['withDeleted'] ? UsersModel::loadByAdmin('1') : UsersModel::loadByAdmin_Deleted('1','0');
                    break;
                case 'usager':
                    $users = $args['withDeleted'] ? UsersModel::load() : UsersModel::loadByDeleted('0');
                    $returnUsers = self::filterUser($users, $args['type']);
                    break;
                case 'externe':
                    $users = $args['withDeleted'] ? UsersModel::load() : UsersModel::loadByDeleted('0');
                    $returnUsers = self::filterUser($users, $args['type']);
                    break;
                case 'interne':
                    $users = $args['withDeleted'] ? UsersModel::load() : UsersModel::loadByDeleted('0');
                    $returnUsers = self::filterUser($users, $args['type']);
                    break;
                default:
                    $returnUsers = $args['withDeleted'] ? UsersModel::load() : UsersModel::loadByDeleted('0');
                    break;
            }
        } else {
            $returnUsers = $args['withDeleted'] ? UsersModel::load() : UsersModel::loadByDeleted('0');
        }
        
        //Gestion de la limite
        if(isset($args['limit'])){
            return array_slice($returnUsers->getArrayCopy(), 0, $args['limit']);
        } else {
            return $returnUsers;
        }
        
    }
    
    public static function findUsersByStructure($structure) {
        return UsersModel::loadByStructureId($structure->getId());
    }
    
    /**
     * Filtre les users par $type
     * @param UsersCollection $users
     * @param string $type
     * @return \AppContext\Models\UsersCollection
     */
    private static function filterUser(UsersCollection $users, string $type) {
        $returnUsers = new UsersCollection();
        foreach ($users as $u) {
            if ($u->beneficiaryfolderId){
                if($type == 'usager') $returnUsers->append($u);
            } elseif ($u->robjectId) {
                if($type == 'externe') $returnUsers->append($u);
            } else {
                if($type == 'interne') $returnUsers->append($u);
            }
        }
        return $returnUsers;
    }
}