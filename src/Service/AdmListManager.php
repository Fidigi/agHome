<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\AdmList;

class AdmListManager
{
    use LoggerTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @param array $data
     * @return AdmList
     */
    public function updateFromArray(array $data): AdmList
    {
        if (empty($data) || (
            empty($data['id']) &&
            empty($data['label']) &&
            empty($data['value']) 
        )) {
            throw new MissingOptionsException();
        }

        $list = $this->entityManager->getRepository(AdmList::class)->findOneById($data['id']);
        $list->setLabel($data['label']);
        $list->setValue($data['value']);
        
        self::save($list);
        return $list;
    }
    
    /**
     * @param array $data
     * @return AdmList
     */
    public function createFromArray(array $data): AdmList
    {
        if (empty($data) || (
            empty($data['tag']) &&
            empty($data['label']) &&
            empty($data['value']) 
        )) {
            throw new MissingOptionsException();
        }
        $list = new AdmList();
        $list->setTag($data['tag']);
        $list->setLabel($data['label']);
        $list->setValue($data['value']);
        
        self::save($list);
        return $list;
    }
    
    /**
     * @param AdmList $list
     * @return bool
     */
    public function save(AdmList $list): ?bool
    {
        try {
            $this->entityManager->persist($list);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
    /**
     * @param AdmList $list
     * @return bool
     */
    public function delete(AdmList $list): ?bool
    {
        try {
            $this->entityManager->remove($list);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
}
