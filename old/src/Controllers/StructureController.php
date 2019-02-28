<?php
namespace AppContext\Controllers;

use AppContext\Models\StructureModel;
use AppContext\Models\UsersModel;
use AppContext\Models\DossierUsagerModel;

class StructureController
{
    
    public static function findStructureByUser(UsersModel $user) {
        return StructureModel::loadByUserId($user->getProId());
    }
    
    public static function findStructureByDos(DossierUsagerModel $dos) {
        return StructureModel::loadByDosId($dos->getDosId());
    }
}