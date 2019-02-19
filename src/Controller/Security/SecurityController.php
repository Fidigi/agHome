<?php
namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Token;
use App\Security\Form\LostType;
use App\Security\Form\RegisterType;
use App\Security\Form\ResetType;
use App\Security\Handler\ActivateHandler;
use App\Security\Handler\LostHandler;
use App\Security\Handler\RegisterHandler;
use App\Security\Handler\ResetHandler;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security/signup", name="security_register")
     */
    public function register(
        Request $request, 
        RegisterHandler $handler
    )
    {
        $form = $this->createForm(RegisterType::class);
        if($handler->handle($form, $request)){
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('security/register.html.twig', [
            'h1_title' => "Register",
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/security/activate/{tokenValue}", name="security_activate")
     */
    public function activate(
        string $tokenValue, 
        ActivateHandler $handler
    )
    {
        if($handler->handle($tokenValue)){
            $this->addFlash('success', 'Your account is activate');
            return $this->redirectToRoute('security_login');
        }
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/security/signin", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'h1_title' => "Login",
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    
    /**
     * @Route("/security/signout", name="security_logout")
     */
    public function logout(){}

    /**
     * @Route("/security/lost", name="security_lost_password")
     */
    public function lostPassword(
        Request $request, 
        LostHandler $handler
    ){
        $form = $this->createForm(LostType::class);
        if($handler->handle($form, $request)){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('security/lost_password.html.twig', [
            'h1_title' => "Forgotten password",
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/security/reset/{tokenValue}", name="security_reset_password")
     */
    public function resetPassword(
        string $tokenValue, 
        Request $request, 
        ResetHandler $handler
    )
    {
        $form = $this->createForm(ResetType::class);
        if($handler->handle($form, $request, $tokenValue)){
            $this->addFlash('success', 'New password is active');
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/reset_password.html.twig', [
            'h1_title' => "Reset password",
            'form' => $form->createView(),
            'token' => $tokenValue
        ]);
    }
}
