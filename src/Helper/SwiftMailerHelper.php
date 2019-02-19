<?php
namespace App\Helper;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\Token;
use App\Service\TokenManager;

class SwiftMailerHelper
{
    use LoggerTrait;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $templating;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @required
     */
    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $templating,
        UrlGeneratorInterface $router
    )
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
    }

    /**
     * @param Token  $token
     *
     * @return void
     */
    public function sendSecurityEmail(Token $token)
    {
        $paramEmail=[];
        
        switch ($token->getType()) {
            case TokenManager::TOKEN_TYPE_REGISTER:
                $paramEmail['title'] = 'Registration Email';
                $paramEmail['view'] = 'emails/security/registration.html.twig';
                $paramEmail['url'] = $this->router->generate('security_activate', array('tokenValue' => $token->getToken()), UrlGeneratorInterface::ABSOLUTE_URL);
                break;
            case TokenManager::TOKEN_TYPE_LOST:
                $paramEmail['title'] = 'Lost Password';
                $paramEmail['view'] = 'emails/security/lost_password.html.twig';
                $paramEmail['url'] = $this->router->generate('security_reset_password', array('tokenValue' => $token->getToken()), UrlGeneratorInterface::ABSOLUTE_URL);
                break;
            default:
                # code...
                break;
        }
        
        $message = (new \Swift_Message($paramEmail['title']))
        ->setFrom('fidigi@gmail.com')
        ->setTo($token->getUser()->getEmail())
        ->setBody(
            $this->templating->render(
                $paramEmail['view'],
                [
                    'name' => $token->getUser()->getDisplayName(),
                    'url' => $paramEmail['url']
                ]
                ),
            'text/html'
            )
        /*
        * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/security/registration.txt.twig',
                ['name' => $name]
            ),
            'text/plain'
            )
        */
        ;
        $this->mailer->send($message);
        self::logInfo('Mail envoye : '.$token->getType().' / user : '.$token->getUser()->getDisplayName());
    }
}