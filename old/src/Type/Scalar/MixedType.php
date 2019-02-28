<?php
namespace AppContext\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

class MixedType extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        // Assuming internal representation of $value is always correct:
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided literal value to use as an input (e.g. in Query AST)
     *
     * @param Node $valueNode
     * @param array|null $variables
     * @return null|string
     * @throws Error
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        return $valueNode->value;
    }
}
