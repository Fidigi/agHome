<?php
namespace App\Security\Handler;

use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Common\HelperTrait\LoggerTrait;
use App\Helper\SwiftMailerHelper;
use App\Service\UserManager;
use App\Service\TokenManager;

class RegisterHandler
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
     * @var SwiftMailerHelper
     */
    private $mailerHelper;
    
    /**
     * @param UserManager $userManager
     * @param TokenManager $tokenManager
     * @param SwiftMailerHelper $mailerHelper
     */
    public function __construct(
        UserManager $userManager,
        TokenManager $tokenManager,
        SwiftMailerHelper $mailerHelper
    )
    {
        $this->userManager = $userManager;
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
            try {
                $user = $this->userManager->register($form->getData());
                $token = $this->tokenManager->createTokenActivationForUser($user);
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

