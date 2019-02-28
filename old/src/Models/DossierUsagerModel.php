<?php
namespace AppContext\Models;

use Fidlib\ObjectType\FidBase;
use Fidlib\ObjectType\CollectionFidObjectManager;
use DatabaseManager;
use DatabaseObj;
use PDO;

class DossierUsagerModel extends DatabaseObj
{
    
    /**
     * Renvoie la connexion principale, ou l'établit si elle n'existe pas
     * @return Database.
     */
    public static function dbConnexionPrincipale() {
        return DatabaseManager::getConnexion('mediateam_grandir-ensemble-preprod-2', 'localhost', 'mediateam', 'medialis');
    }
    
    public static function loadByGroupeId(int $groupId){
        $query = "	SELECT `dossier_usager`.*
					FROM `dossier_usager`, `dossier_dans_groupe`
                    WHERE `dossier_usager`.`dos_id` = `dossier_dans_groupe`.`dos_id`
                    AND `dossier_usager`.`updated_at` = `dossier_dans_groupe`.`updated_at`
                    AND `dossier_dans_groupe`.`group_id` = ".$groupId;
        $stmt = self::dbConnexionPrincipale()->prepare($query);
        $stmt->execute();
        $structureCollection = new StructureCollection();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $object = new StructureModel();
            $structureCollection->append(FidBase::factory($object,$row));
        }
        $stmt = null;
        return $structureCollection === null ? new StructureCollection() : $structureCollection;
    }
}
class DossierUsagerCollection extends CollectionFidObjectManager {
    
}
