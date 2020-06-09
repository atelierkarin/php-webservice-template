<?php

require_once './bootstrap.php';

use KarinP\TemplateWS\Type\Query;
use KarinP\TemplateWS\Type\Mutation;
use KarinP\TemplateWS\Service\LogService;

use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;

try {
    $queryType = Query::getInstance();
    $mutationType = Mutation::getInstance();
    $schema = new Schema([
        'query' => $queryType,
        'mutation' => $mutationType
    ]);
    $server = new StandardServer([
        'schema' => $schema,
        'errorsHandler' => function(array $errors, callable $formatter) {
            LogService::getInstance()->error(json_encode($errors));
            return array_map($formatter, $errors);
        }
    ]);
    $server->handleRequest();
} catch (\Throwable $e) {
    $log->error($e->getMessage()." - ".$e->getTraceAsString());
    StandardServer::send500Error($e);
}