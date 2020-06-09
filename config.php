<?php

// Database Settings
$config = [

    "app" => [
        "name" => "Web Service Template",
        "version" => "0.0.0",
        "status" => "dev"
    ],

    "database" => [
        "db1" => [
            "dev" => [
                "driver" => "mysql",
                "host" => "",
                "database" => "",
                "username" => "",
                "password" => ""
            ],
            "prd" => [
                "driver" => "mysql",
                "host" => "",
                "database" => "",
                "username" => "",
                "password" => ""
            ]
        ],
    ],

    "api" => [
        "api1" => [
            "dev" => [
                "url" => "",
                "secret" => ""
            ],
            "prd" => [
                "url" => "",
                "secret" => ""
            ]
        ]
    ],

    // Use File
    "log" => [
        "type" => "file",
        "dir" => dirname(__FILE__) . "./log/",
        "file" => "debug.log",
        "level" => 100           // INFO
    ],

    // Use Sentry
//    "log" => [
//        "type" => "sentry",
//        "url" => "",
//        "level" => 100           // INFO
//    ],
];