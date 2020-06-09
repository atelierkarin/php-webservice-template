<?php

namespace KarinP\TemplateWS\Service;

class MainService extends BaseService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getVersion(): String
    {
        return $this->config["app"]["version"];
    }
}