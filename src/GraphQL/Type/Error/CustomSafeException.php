<?php
namespace App\GraphQL\Type\Error;

use GraphQL\Error\ClientAware;

class CustomSafeException extends \Exception implements ClientAware
{
    protected $cat = 'CustomSafe';

    public function isClientSafe()
    {
        return true;
    }

    public function getCategory()
    {
        return $this->cat;
    }

    public function setCategory(string $string)
    {
        $this->cat = $string;
        return $this;
    }
}