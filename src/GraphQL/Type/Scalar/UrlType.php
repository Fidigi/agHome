<?php
namespace App\GraphQL\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Utils\Utils;
use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;

class UrlType extends ScalarType implements AliasedInterface
{
    public static function getAliases()
    {
        return ['Url', 'Url'];
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
        // return $this->parseValue($value);
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        if (!is_string($value) || !filter_var($value, FILTER_VALIDATE_URL)) { // quite naive, but after all this is example
            throw new Error("Cannot represent value as URL: " . Utils::printSafe($value));
        }
        return $value;
    }

    /**
     * @param Node $valueNode
     * @param array|null $variables
     * @return null|string
     * @throws Error
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        // Note: throwing GraphQL\Error\Error vs \UnexpectedValueException to benefit from GraphQL
        // error location in query:
        if (!($valueNode instanceof StringValueNode)) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        if (!is_string($valueNode->value) || !filter_var($valueNode->value, FILTER_VALIDATE_URL)) {
            throw new Error('Query error: Not a valid URL', [$valueNode]);
        }
        return $valueNode->value;
    }
}
