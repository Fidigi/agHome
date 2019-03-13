<?php

namespace App\GraphQL\Mutation;

use App\Repository\UserRepository;
use App\Service\TokenManager;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

/*
mutation{
  token_new(token:{user_uuid:"4ad11d95-5f89-40da-b118-76ec96f57cb6"}){
    token
  }
}
*/

class TokenMutation implements MutationInterface , AliasedInterface
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
        TokenManager $tokenManager
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array{
        return [
            'new' => 'tokenNew' ,
  
        ];
    }

    public function new(array $input){
        $user = $this->userRepository->findOneByUuid($input['user_uuid']);
        return $this->tokenManager->createTokenApiForUser($user);
    }

}