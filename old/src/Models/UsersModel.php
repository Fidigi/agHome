<?php
namespace AppContext\Models;

//use GraphQL\Utils\Utils;
use Fidlib\ObjectType\FidBase;
use Fidlib\ObjectType\CollectionFidObjectManager;
use DatabaseManager;
use DatabaseObj;
use PDO;

class UsersModel extends DatabaseObj
{
    
    /**
     * Renvoie la connexion principale, ou l'établit si elle n'existe pas
     * @return Database.
     */
    public static function dbConnexionPrincipale() {
        return DatabaseManager::getConnexion('mediateam_grandir-ensemble-preprod-2', 'localhost', 'mediateam', 'medialis');
    }
    
    public static function dbPrimaryKey() {
        return 'pro_id';
    }
    
    /**
     * Return structure's user
     * @param int $userId
     * @return \AppContext\Models\StructureCollection
     */
    public static function loadByStructureId(int $structureId) {
        $query = "	SELECT `users`.*
					FROM `users`, `structure_person`
                    WHERE `users`.`pro_id` = `structure_person`.`user_id`
                    AND `structure_person`.`structure_id` = ".$structureId;
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
class UsersCollection extends CollectionFidObjectManager {
    
}
