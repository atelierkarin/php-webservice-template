<?php

namespace KarinP\TemplateWS\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class SomethingCustom extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'SomethingCustom',
            'fields' => [
                'id' => Type::int(),
                'field_1' => Type::string()
            ],
        ];
        parent::__construct($config);
    }

    private static $singleton;

    public static function getInstance(): self
    {
        return self::$singleton ? self::$singleton : self::$singleton = new self();
    }
}