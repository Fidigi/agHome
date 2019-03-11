<?php
namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;

class DateTimeType extends ScalarType implements AliasedInterface
{
    public static function getAliases()
    {
        return ['DateTime', 'Date'];
    }

    /**
     * @param \DateTimeInterface $value
     * @return string
     */
    public function serialize($value)
    {
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $value
     * @return \DateTimeInterface
     */
    public function parseValue($value)
    {
        return new \DateTimeImmutable($value);
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
     *
     * @param \GraphQL\Language\AST\Node $valueNode
     * @return \DateTimeInterface
     */
    public function parseLiteral($valueNode, array $variables = NULL)
    {
        return new \DateTimeImmutable($valueNode->value);
    }
}
