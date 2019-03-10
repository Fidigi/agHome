<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Common\HelperTrait\LoggerTrait;
use App\Entity\Token;
use App\Entity\User;
use Faker\Factory;

class TokenManager
{
    const TOKEN_TYPE_REGISTER = 'REG';
    const TOKEN_TYPE_LOST = 'LOST';
    const TOKEN_TYPE_API = 'API';

    const TOKEN_REGISTER_DURATION = 'now +1 day';
    const TOKEN_LOST_DURATION = 'now +10 min';
    const TOKEN_API_LONG_DURATION = 'now +1 month';
    const TOKEN_API_SHORT_DURATION = 'now +10 hours';

    use LoggerTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var TokenGeneratorInterface
     */
    protected $tokenGenerator;

    /**
     * @param ObjectManager $entityManager
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function __construct(
        ObjectManager $entityManager,
        TokenGeneratorInterface $tokenGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param User $user
     * @return Token
     */
    public function createTokenActivationForUser(User $user)
    {
        $data = [];
        $data['user']=$user;
        $data['type']=self::TOKEN_TYPE_REGISTER;
        $data['expired_at']=self::TOKEN_REGISTER_DURATION;
        return self::createFromArray($data);
    }

    /**
     * @param User $user
     * @return Token
     */
    public function createTokenLostForUser(User $user)
    {
        $data = [];
        $data['user']=$user;
        $data['type']=self::TOKEN_TYPE_LOST;
        $data['expired_at']=self::TOKEN_LOST_DURATION;
        return self::createFromArray($data);
    }

    /**
     * @param User $user
     * @return Token
     */
    public function createTokenApiForUser(User $user, Bool $duration = false)
    {
        $data = [];
        $data['user']=$user;
        $data['type']=self::TOKEN_TYPE_API;

        //Invalider ancien token
        $tokens = $this->entityManager->getRepository(Token::class)->findBy($data);
        foreach ($tokens as $token) {
            if($token->isExpired() === false){
                $token->setExpiredAt(null);
                self::save($token);
            }
        }

        if($duration) $data['expired_at']=self::TOKEN_API_LONG_DURATION; 
        else $data['expired_at']=self::TOKEN_API_SHORT_DURATION;

        return self::createFromArray($data);
    }
    
    /**
     * @param array $data
     * @return Token
     */
    public function createFromArray(array $data): Token
    {
        if (empty($data) || (
            empty($data['user']) &&
            empty($data['type']) 
        )) {
            throw new MissingOptionsException();
        }
        $token = new Token();
        $token->setToken($this->tokenGenerator->generateToken());
        $token->setUser($data['user']);
        $token->setType($data['type']);
        
        $token->setCreatedAt(new \Datetime());
        if($data['expired_at']){
            $token->setExpiredAt(new \Datetime($data['expired_at']));
        }
        
        self::save($token);
        return $token;
    }
    
    /**
     * @param Token $token
     * @return bool
     */
    public function save(Token $token): ?bool
    {
        try {
            $this->entityManager->persist($token);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
    /**
     * @param Token $token
     * @return bool
     */
    public function delete(Token $token): ?bool
    {
        try {
            $this->entityManager->remove($token);
        } catch (ORMException $e) {
            self::logError($e->getMessage());
            return false;
        }
        $this->entityManager->flush();
        return true;
    }
    
}
