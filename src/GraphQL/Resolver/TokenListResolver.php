<?php

namespace App\GraphQL\Resolver;

use App\Repository\TokenRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class TokenListResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    /**
     *
     * @param TokenRepository $tokenRepository
     */
    public function __construct(TokenRepository $tokenRepository){
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolve(Argument $args){
        return ['token' => $this->tokenRepository->findBy(
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
            'resolve' => 'TokenList',
        ];
    }

}