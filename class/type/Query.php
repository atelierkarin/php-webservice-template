<?php

namespace KarinP\TemplateWS\Type;

use KarinP\TemplateWS\Service\MainService;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class Query extends ObjectType
{
    /** @var MainService $main */
    private $main;

    public function __construct()
    {
        $this->main = MainService::getInstance();

        $config = [
            'name' => 'Query',
            'fields' => [
                'version' => [
                    'type' => Type::string(),
                    'args' => [
                        'secret' => Type::nonNull(Type::string()),
                    ],
                    'description' => 'Get the version of API',
                    'resolve' => function ($val, $args) {
                        return $this->main->getVersion();
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