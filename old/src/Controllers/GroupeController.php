<?php
namespace AppContext\Controllers;

use AppContext\Models\GroupeAppartenanceModel;
use AppContext\Models\StructureModel;

class GroupeController
{
    
    public static function findGroupeByStructure(StructureModel $structure) {
        return GroupeAppartenanceModel::loadByStructureId($structure->getId());
    }
    
}