<?php
namespace AppContext\Controllers;

use AppContext\Models\GroupeAppartenanceModel;
use AppContext\Models\DossierUsagerModel;

class DossierUsagerController
{
    
    public static function findDossierUsagerByGroupe(GroupeAppartenanceModel $groupe) {
        return DossierUsagerModel::loadByGroupeId($groupe->getId());
    }
    
}