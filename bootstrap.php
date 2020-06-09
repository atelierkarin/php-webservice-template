<?php
ini_set('session.cookie_secure', 1);
header('content-type: application/json; charset=utf-8');
header('X-FRAME-OPTIONS: DENY');
$allowed_origins = [];
check_origin($allowed_origins);

function check_origin($allowed_origins) {
    $headers = apache_request_headers();
    error_log(json_encode($headers));
    $origin = isset($headers['Origin'])? $headers['Origin'] : (isset($headers['origin'])? $headers['origin'] : '*');
    if(is_allowed_origin($origin, $allowed_origins)){
        header('Access-Control-Allow-Origin: '.$origin);
        header('Access-Control-Allow-Headers: origin, content-type, accept');
    }
}

function is_allowed_origin($origin, $allowed_origins) {
    $return_value = false;
    foreach($allowed_origins as $a){
        if(preg_match('/^https?:\\/\\/([a-zA-Z\d-]+\\.){0,}'.$a.'$/', $origin)) {
            $return_value = true;
            break;
        }
    }
    return $return_value;
}

// Do not do anything if OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once dirname(__FILE__) .'/vendor/autoload.php';
require_once dirname(__FILE__) .'/config.php';

use KarinP\TemplateWS\Service\LogService;
use KarinP\TemplateWS\Service\ConfigService;

// Current Status
$app_status = $config["app"]["status"];

// Init Config
$config_service = ConfigService::getInstance();
$config_service->setConfig($config);

// Set Up Log
$log = LogService::getInstance();
