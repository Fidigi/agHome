<?php
namespace App\GraphQL\Type;

/*use AppContext\Type\MutationType;
use AppContext\Type\NodeType;
use AppContext\Type\QueryType;
use AppContext\Type\Definition\DossierUsagerType;
use AppContext\Type\Definition\GroupeType;
use AppContext\Type\Definition\StructureType;
use AppContext\Type\Definition\UserType;
use AppContext\Type\Enum\ContentFormatEnum;
use AppContext\Type\Enum\ObjectTypeEnum;
use AppContext\Type\Enum\UsersTypeEnum;
use AppContext\Type\Field\HtmlField;
use AppContext\Type\Scalar\EmailType;
use AppContext\Type\Scalar\MixedType;
use AppContext\Type\Scalar\UrlType;*/
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\Type;

use App\GraphQL\Type\Input\LoginInput;

/**
 * Class Types
 *
 * Acts as a registry and factory for your types.
 *
 * As simplistic as possible for the sake of clarity of this example.
 * Your own may be more dynamic (or even code-generated).
 *
 * @package GraphQL\App
 */
class Types
{
    // Object types:
    //private static $user;

    /**
     * @return UserType
     */
    /*public static function user()
    {
        return self::$user ?: (self::$user = new UserType());
    }*/


    // Interface types
    //private static $node;

    /**
     * @return NodeType
     */
    /*public static function node()
    {
        return self::$node ?: (self::$node = new NodeType());
    }*/
    
    
    // Input types
    private static $loginInput;
    
    /**
     * @return LoginInput
     */
    public static function loginInput()
    {
        return self::$loginInput ?: (self::$loginInput = new LoginInput());
    }


    // Enum types
    //private static $objectTypeEnum;
    
    /**
     * @return ObjectTypeEnum
     */
    /*public static function objectTypeEnum()
    {
        return self::$objectTypeEnum ?: (self::$objectTypeEnum = new ObjectTypeEnum());
    }*/

    // Custom Scalar types:
    //private static $emailType;
    
    /**
     * @return \GraphQL\Type\Definition\CustomScalarType
     */
    /*public static function email()
    {
        return self::$emailType ?: (self::$emailType = EmailType::create());
    }*/



    // Let's add internal types

    public static function boolean()
    {
        return Type::boolean();
    }

    /**
     * @return \GraphQL\Type\Definition\FloatType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return \GraphQL\Type\Definition\IDType
     */
    public static function id()
    {
        return Type::id();
    }

    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @param Type $type
     * @return NonNull
     */
    public static function nonNull($type)
    {
        return new NonNull($type);
    }
}
