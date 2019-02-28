<?php
namespace AppContext;

use AppContext\Models\UsersModel;
use Fidlib\ObjectType\FidObject;

/**
 * Class AppContext
 * Instance available in all GraphQL resolvers as 3rd argument
 *
 * @package GraphQL\App
 */
class AppContext extends FidObject {
    /**
     * @var string
     */
    public $rootUrl;

    /**
     * @var UsersModel
     */
    public $viewer;

    /**
     * @var mixed
     */
    public $request;
}
