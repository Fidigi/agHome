<?php

namespace App\GraphQL\Mutation;

use App\Entity\AdmList;
use App\Service\AdmListManager;
use Overblog\GraphQLBundle\Error\UserError;
use Overblog\GraphQLBundle\Error\UserErrors;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\GraphQL\Type\Error\CustomSafeException;
use Doctrine\Common\Persistence\ObjectManager;
/*
mutation{
  list_action(list:{label:"Yes No",values:[{id:"1",value:"Yes"},{id:"2",value:"No"}]}){
		lists{
      id
      tag
      label
      value
    }
  }
}
*/

class AdmListMutation implements MutationInterface , AliasedInterface
{
    
    /**
     * @var AdmListManager
     */
    private $listManager;
    
    /**
     * @var ObjectManager
     */
    private $handler;
    
    /**
     * @param AdmListManager $listManager
     */
    public function __construct(
        AdmListManager $listManager,
        ObjectManager $handler
    )
    {
        $this->listManager = $listManager;
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array{
        return [
            'listAction' => 'listAction' ,
        ];
    }

    public function listAction(array $input){
        $errors = [];
        $existingList = null;
        $existingLabelList = null;
        $tag = null;
        try {
            if(!$input['tag'] || $input['tag'] == ''){
                $tag = trim(preg_replace('#[^\\pL\d]+#u', '-', $input['label']), '-');
                if (function_exists('iconv'))
                {
                    $tag = iconv('utf-8', 'us-ascii//TRANSLIT', $tag);
                }
                $tag = preg_replace('#[^-\w]+#', '', strtolower($tag));
                $existingList = $this->handler->getRepository(AdmList::class)->findByTag($tag);
                if ($existingList != null) {
                    throw (new CustomSafeException('Already exist'))->setCategory('label');
                }
                $existingLabelList = $this->handler->getRepository(AdmList::class)->findByLabel($input['label']);
            } else {
                $existingList = $this->handler->getRepository(AdmList::class)->findByTag($input['tag']);
                if ($existingList == null) {
                    throw (new CustomSafeException('not-found'))->setCategory('tag');
                } 
                $tag = $existingList[0]->getTag();
                if($existingList[0]->getLabel() != $input['label']){
                  $existingLabelList = $this->handler->getRepository(AdmList::class)->findByLabel($input['label']);
                }
            } 
            if($existingLabelList != null){
              throw (new CustomSafeException('Already exist'))->setCategory('label');
            }
        } catch (\Throwable $th) {
          if($th instanceof CustomSafeException){
            throw $th;
          }
        }

        $lists = [];
        foreach($input['values'] as $rawlist){
            $list = null;
            if($rawlist['id'] == null || $rawlist['id'] == 0){
                $list = $this->listManager->createFromArray([
                    'tag' => $tag,
                    'label' => $input['label'],
                    'value' => $rawlist['value']
                ]);
            } elseif($rawlist['id'] != null && $existingList == null) {
                throw new UserError('Hacking');
            } else {
                $key = null;
                foreach($existingList as $index => $eList){
                    if ($rawlist['id'] == $eList->getId()) {
                        unset($existingList[$index]); 
                        $key = $index;
                        break;
                    }
                }
                if($key === null){
                    throw new UserError('Hacking');
                }
                $list = $this->listManager->updateFromArray([
                    'id' => $rawlist['id'],
                    'label' => $input['label'],
                    'value' => $rawlist['value']
                ]);

            }
            array_push($lists,$list);
        }
        foreach($existingList as $index => $eList){
            $this->listManager->delete($eList);
        }

        if (!empty($errors)) {
            throw new UserErrors($errors);
        }

        return ['lists' => $lists];
    }

}