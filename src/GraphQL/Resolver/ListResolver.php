<?php

namespace App\GraphQL\Resolver;

use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Symfony\Component\Security\Core\Security;

class ListResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
        Security $security, 
        UserRepository $userRepository
    ){
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolve(Argument $args){
        return $this->userRepository->find($args['id']);
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolveList(Argument $args){
        return ['list' => $this->userRepository->findBy(
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
            'resolve' => 'List',
            'resolveList' => 'ListList',
        ];
    }

}