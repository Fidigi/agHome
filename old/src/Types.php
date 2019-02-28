<?php
namespace AppContext;

use AppContext\Type\MutationType;
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
use AppContext\Type\Scalar\UrlType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\Type;
use AppContext\Type\Input\SaveDataInput;

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
    private static $user;
    private static $structure;
    private static $dossierUsager;
    private static $groupe;
    private static $query;
    private static $mutation;

    /**
     * @return UserType
     */
    public static function user()
    {
        return self::$user ?: (self::$user = new UserType());
    }

    /**
     * @return StructureType
     */
    public static function structure()
    {
        return self::$structure ?: (self::$structure = new StructureType());
    }

    /**
     * @return DossierUsagerType
     */
    public static function dossierUsager()
    {
        return self::$dossierUsager ?: (self::$dossierUsager = new DossierUsagerType());
    }

    /**
     * @return GroupeType
     */
    public static function groupe()
    {
        return self::$groupe ?: (self::$groupe = new GroupeType());
    }

    /**
     * @return QueryType
     */
    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }
    
    /**
     * @return MutationType
     */
    public static function mutation()
    {
        return self::$mutation ?: (self::$mutation = new MutationType());
    }


    // Interface types
    private static $node;

    /**
     * @return NodeType
     */
    public static function node()
    {
        return self::$node ?: (self::$node = new NodeType());
    }
    
    
    // Input types
    private static $saveDataInput;
    
    /**
     * @return SaveDataInput
     */
    public static function saveDataInput()
    {
        return self::$saveDataInput ?: (self::$saveDataInput = new SaveDataInput());
    }


    // Enum types
    private static $usersTypeEnum;
    private static $contentFormatEnum;
    private static $objectTypeEnum;

    /**
     * @return UsersTypeEnum
     */
    public static function userTypeEnum()
    {
        return self::$usersTypeEnum ?: (self::$usersTypeEnum = new UsersTypeEnum());
    }

    /**
     * @return ContentFormatEnum
     */
    public static function contentFormatEnum()
    {
        return self::$contentFormatEnum ?: (self::$contentFormatEnum = new ContentFormatEnum());
    }
    
    /**
     * @return ObjectTypeEnum
     */
    public static function objectTypeEnum()
    {
        return self::$objectTypeEnum ?: (self::$objectTypeEnum = new ObjectTypeEnum());
    }

    // Custom Scalar types:
    private static $urlType;
    private static $emailType;
    private static $mixedType;
    
    /**
     * @return \GraphQL\Type\Definition\CustomScalarType
     */
    public static function email()
    {
        return self::$emailType ?: (self::$emailType = EmailType::create());
    }

    /**
     * @return UrlType
     */
    public static function url()
    {
        return self::$urlType ?: (self::$urlType = new UrlType());
    }
    
    /**
     * @return MixedType
     */
    public static function mixed()
    {
        return self::$mixedType ?: (self::$mixedType = new MixedType());
    }

    /**
     * @param $name
     * @param null $objectKey
     * @return array
     */
    public static function htmlField($name, $objectKey = null)
    {
        return HtmlField::build($name, $objectKey);
    }



    // Let's add internal types as well for consistent experience

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
