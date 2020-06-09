<?php

namespace KarinP\TemplateWS\Service;

abstract class BaseService
{
    protected $config;
    protected $logger;

    public function __construct()
    {
        $config = ConfigService::getInstance()->loadConfig();
        $this->config = $config;

        $this->logger = LogService::getInstance();
    }

    // Singleton Config
    final public static function getInstance()
    {
        static $instances = array();

        $calledClass = get_called_class();

        $instances[$calledClass] ??= new $calledClass();

        return $instances[$calledClass];
    }
}