<?php

namespace KarinP\TemplateWS\Type;

use KarinP\TemplateWS\Service\MainService;
use KarinP\TemplateWS\Service\ConfigService;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Mutation extends ObjectType
{
    /** @var MainService $main */
    private $main;

    public function __construct()
    {
        $this->main = MainService::getInstance();

        $config = [
            'name' => 'Mutation',
            'fields' => [
                'mutation1' => [
                    'args' => [
                        'para_1' => Type::nonNull(Type::string()),
                        'para_2' => Type::nonNull(Type::string()),
                    ],
                    'type' => new ObjectType([
                        'name' => 'SomeCustomType',
                        'fields' => [
                            'field_1' => Type::string(),
                            'field_2' => Type::int(),
                            'field_3' => Type::nonNull(Type::string())
                        ]
                    ]),
                    'resolve' => function($val, $args) {
                        return "CALL SOMETHING HERE";
                    }
                ],
            ]
        ];
        parent::__construct($config);
    }

    private static $singleton;

    public static function getInstance(): self
    {
        return self::$singleton ? self::$singleton : new self();
    }
}