<?php

namespace App\GraphQL\Resolver;

use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class UserListResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolve(Argument $args){
        return ['user' => $this->userRepository->findBy(
            [],
            [],
            $args['limit'],
            0
        )];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array{
        return [
            'resolve' => 'UserList',
        ];
    }

}