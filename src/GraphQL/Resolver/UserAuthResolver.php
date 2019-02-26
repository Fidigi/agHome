<?php

namespace App\GraphQL\Resolver;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class UserAuthResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var Security 
     */
    private $security;

    /**
     *
     */
    public function __construct(Security $security){
        $this->security = $security;
    }

    /**
     * @return null|object
     */
    public function resolve(){
        return $this->security->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array{
        return [
            'resolve' => 'UserAuth',
        ];
    }

}