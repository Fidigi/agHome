<?php

namespace App\GraphQL\Mutation;

use App\Repository\UserRepository;
use App\Service\TokenManager;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/*
mutation{
  signin(crendentials:{username:"admin",password:"pass"}){
    token
  }
}
*/

class LoginMutation implements MutationInterface , AliasedInterface
{
    
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * @var TokenManager
     */
    private $tokenManager;
    
    /**
     * @param UserRepository $userRepository
     * @param TokenManager $tokenManager
     */
    public function __construct(
        UserRepository $userRepository,
        TokenManager $tokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array{
        return [
            'login' => 'login' ,
        ];
    }

    public function login(array $input){
        $user = $this->userRepository->findOneByUsernameOrEmail($input['username']);
  
        if ( $this->passwordEncoder->isPasswordValid($user, $input['password']) == false){
          return null;
        }

        return $this->tokenManager->createTokenApiForUser($user, $input['remember']);
    }

}