<?php

namespace KarinP\TemplateWS\Service;

use \PDO;

class DBService {

    private $dbs;

    private $logger;
    private $config;
    private $status;

    public function __construct(array $config = null) {
        $this->logger = LogService::getInstance();
        $this->config = ConfigService::getInstance()->loadConfig();
        $this->status = $this->config["app"]["status"];
    }

    private function createConnection(string $name): PDO {
        $config = $this->config["database"][$name][$this->status];
        $port = $config["port"]??3306;
        $dbObj = new PDO("mysql:host=" . $config["host"] .
            ";port=" . $port .
            ";dbname=" . $config["database"], $config["username"], $config["password"]);
        $dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbObj->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
        $dbObj->exec("set names utf8");
        return $dbObj;
    }

    public function getDb(string $name): ?PDO {
        try {
            $db_config = null;
            if (isset($this->config["database"][$name][$this->status])) {
                $db_config = $this->config["database"][$name][$this->status];
            }
            if (!$db_config) {
                $this->logger->error("Unknown DB: ".$name);
                return null;
            }
            if (!isset($this->dbs[$name])) {
                $new_conn = $this->createConnection($name);
                $this->dbs[$name] = $new_conn;
            }
            return $this->dbs[$name];
        } catch (\Throwable $e) {
            $this->logger->error("Error in Get DB: ".$e->getMessage());
            return null;
        }
    }

    private static $singleton;
    public static function getInstance(): self
    {
        return self::$singleton ?? self::$singleton = new self();
    }
}