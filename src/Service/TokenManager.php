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
        return self::createFromArray($data);
    }

    /**
     * @param User $user
     * @return Token
     */
    public function createTokenApiForUser(User $user)
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
