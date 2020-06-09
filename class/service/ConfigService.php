<?php

namespace KarinP\TemplateWS\Service;

class ConfigService {

    private $config;

    public function setConfig(array $config) {
        $this->config = $config;
    }

    public function loadConfig(): array {
        return $this->config;
    }

    private static $singleton;
    public static function getInstance(): self
    {
        return self::$singleton ?? self::$singleton = new self();
    }
}