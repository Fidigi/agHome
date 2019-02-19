<?php
namespace App\Security\Handler;

use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\Token;
use App\Repository\TokenRepository;
use App\Service\UserManager;
use App\Service\TokenManager;

class ResetHandler
{
    use LoggerTrait;

    /**
     * @var UserManager
     */
    private $userManager;
    
    /**
     * @var TokenManager
     */
    private $tokenManager;
    
    /**
     * @var TokenRepository
     */
    private $tokenRepository;
    
    /**
     * @param UserManager $userManager
     * @param TokenManager $tokenManager
     * @param TokenRepository $tokenRepository
     */
    public function __construct(
        UserManager $userManager,
        TokenManager $tokenManager,
        TokenRepository $tokenRepository
    )
    {
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
        $this->tokenRepository = $tokenRepository;
    }
    
    /**
     * @param String $tokenValue
     * @return boolean
     */
    public function handle(
        FormInterface $form,
        Request $request,
        string $tokenValue
    )
    {
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $token = $this->tokenRepository->findOneBy([
                'token' => $tokenValue,
                'type' => TokenManager::TOKEN_TYPE_LOST
            ]);
            if ($token === null) {
                $form->addError(new FormError("Unknow user"));
                return false;
            }
            $this->userManager->changePassword($token->getUser(),$form->getData()['password']);
            try {
                $this->userManager->save($token->getUser());
                $this->tokenManager->delete($token);
            } catch (Exception $e) {
                self::logError($e->getMessage());
                $form->addError(new FormError("Erreur lors de l'insertion en base"));
                return false;
            }
            return true;
        }
        return false;
    }
}

