<?php
namespace AppContext\Type;

use AppContext\Models\StructureModel;
use AppContext\Models\UsersModel;
use AppContext\Types;
use GraphQL\Type\Definition\InterfaceType;

class NodeType extends InterfaceType
{
    
    /**
     * Set node configuration
     */
    public function __construct()
    {
        $config = [
            'name' => 'Node',
            'fields' => [
                'id' => Types::id()
            ],
            'resolveType' => [$this, 'resolveNodeType']
        ];
        parent::__construct($config);
    }

    /**
     * Return good instance of object
     * @param object $object
     */
    public function resolveNodeType($object)
    {
        if ($object instanceof UsersModel) {
            return Types::user();
        } else if ($object instanceof StructureModel) {
            return Types::structure();
        }
    }
}
