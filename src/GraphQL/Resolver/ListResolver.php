<?php

namespace App\GraphQL\Resolver;

use App\Repository\AdmListRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Symfony\Component\Security\Core\Security;

class ListResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var AdmListRepository
     */
    private $admListRepository;

    /**
     *
     * @param AdmListRepository $admListRepository
     */
    public function __construct(
        Security $security, 
        AdmListRepository $admListRepository
    ){
        $this->security = $security;
        $this->admListRepository = $admListRepository;
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolve(Argument $args){
        return $this->admListRepository->find($args['id']);
    }

    /**
     * @param Argument $args
     * @return null|object
     */
    public function resolveList(Argument $args){
        $criteria = [];
        if($args['tag']){
            $criteria['tag'] = $args['tag'];
        }
        return ['lists' => $this->admListRepository->findBy(
            $criteria,
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