<?php
namespace AppContext\Models;

use Fidlib\ObjectType\CollectionFidObjectManager;
use DatabaseManager;
use DatabaseObj;

class GroupeAppartenanceModel extends DatabaseObj
{
    
    /**
     * Renvoie la connexion principale, ou l'établit si elle n'existe pas
     * @return Database.
     */
    public static function dbConnexionPrincipale() {
        return DatabaseManager::getConnexion('mediateam_grandir-ensemble-preprod-2', 'localhost', 'mediateam', 'medialis');
    }
}
class GroupeAppartenanceCollection extends CollectionFidObjectManager {
    
}
