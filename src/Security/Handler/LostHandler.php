<?php
namespace App\Security\Handler;

use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Common\HelperTrait\LoggerTrait;
use App\Helper\SwiftMailerHelper;
use App\Repository\UserRepository;
use App\Service\TokenManager;

class LostHandler
{
    use LoggerTrait;
    
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * @var TokenManager
     */
    private $tokenManager;
    
    /**
     * @var SwiftMailerHelper
     */
    private $mailerHelper;
    
    /**
     * @param UserRepository $userRepository
     * @param TokenManager $tokenManager
     * @param SwiftMailerHelper $mailerHelper
     */
    public function __construct(
        UserRepository $userRepository,
        TokenManager $tokenManager,
        SwiftMailerHelper $mailerHelper
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
        $this->mailerHelper = $mailerHelper;
    }
    
    /**
     * @param FormInterface $form
     * @param Request $request
     * @return boolean
     */
    public function handle(FormInterface $form,Request $request)
    {
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->userRepository->findOneByUsernameOrEmail($form->getData()['username']);
            if ($user === null) {
                $form->addError(new FormError("Unknow user"));
                return false;
            }
            try {
                $token = $this->tokenManager->createTokenLostForUser($user);
                $this->mailerHelper->sendSecurityEmail($token);
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

