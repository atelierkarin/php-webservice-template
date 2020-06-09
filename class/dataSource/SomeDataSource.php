<?php

namespace KarinP\TemplateWS\DataSource;

use KarinP\TemplateWS\Model\Something;
use KarinP\TemplateWS\Service\DBService;
use KarinP\TemplateWS\Service\LogService;

class SomeDataSource
{

    const SQL_GET = "SELECT * FROM DB_1 WHERE id = ? LIMIT 1";
    const SQL_INSERT = "INSERT INTO DB_1 (id, field_1) VALUES (?, ?)";

    public static function get(int $id): ?Something
    {
        $rtn_value = null;
        $db = DBService::getInstance()->getDb("db1");
        try {
            $stmt = $db->prepare(self::SQL_GET);
            $stmt->execute([$id]);
            $stmt->setFetchMode(\PDO::FETCH_CLASS,'KarinP\\TemplateWS\\Something');
            if ($result = $stmt->fetch()) {
                $rtn_value = $result;
            }
        } catch (\Throwable $e) {
            LogService::getInstance()->error(__CLASS__ . " " . __FUNCTION__ . " Database Error " . $e->getMessage());
        }
        return $rtn_value;
    }

    public static function create(int $id, string $field_1): ?Something
    {
        $db = DBService::getInstance()->getDb("db1");
        try {
            $stmt = $db->prepare(self::SQL_INSERT);
            $result = $stmt->execute([$id, $field_1]);
            if ($result) {
                return self::get($id);
            } else {
                LogService::getInstance()->error(__CLASS__ . " " . __FUNCTION__ . " Cannot create ID: " . $id);
                return null;
            }
        } catch (\Throwable $e) {
            LogService::getInstance()->error(__CLASS__ . " " . __FUNCTION__ . " Database Error " . $e->getMessage());
        }
        return null;
    }
}