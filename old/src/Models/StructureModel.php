<?php
namespace AppContext\Models;

use Fidlib\ObjectType\FidBase;
use Fidlib\ObjectType\CollectionFidObjectManager;
use DatabaseManager;
use DatabaseObj;
use PDO;

class StructureModel extends DatabaseObj
{
    
    /**
     * Renvoie la connexion principale, ou l'établit si elle n'existe pas
     * @return Database.
     */
    public static function dbConnexionPrincipale() {
        return DatabaseManager::getConnexion('mediateam_grandir-ensemble-preprod-2', 'localhost', 'mediateam', 'medialis');
    }
    
    /**
     * Return user's structure
     * @param int $userId
     * @return \AppContext\Models\StructureCollection
     */
    public static function loadByUserId(int $userId){
        $query = "	SELECT `structure`.*
					FROM `structure`, `structure_person`
                    WHERE `structure`.`id` = `structure_person`.`structure_id`
                    AND `structure_person`.`user_id` = ".$userId;
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
    
    public static function loadByDosId(int $dosId){
        $query = "	SELECT `structure`.*
					FROM `structure`, `dossier_usager_by_structure`
                    WHERE `structure`.`id` = `structure_person`.`structure_id`
                    AND `structure_person`.`user_id` = ".$dosId;
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
class StructureCollection extends CollectionFidObjectManager {
    
}
