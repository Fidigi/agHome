<?php
namespace App\Security\Handler;

use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Common\HelperTrait\LoggerTrait;
use App\Repository\TokenRepository;
use App\Service\UserManager;
use App\Service\TokenManager;

class ActivateHandler
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
    public function handle(string $tokenValue)
    {
        $token = $this->tokenRepository->findOneBy([
            'token' => $tokenValue,
            'type' => TokenManager::TOKEN_TYPE_REGISTER
        ]);
        if ($token === null) {
            return false;
        }
        try {
            $this->userManager->save($token->getUser()->setActive(true));
            $this->tokenManager->delete($token);
        } catch (Exception $e) {
            self::logError($e->getMessage());
            $form->addError(new FormError("Erreur lors de l'insertion en base"));
            return false;
        }
        return true;
    }
}

