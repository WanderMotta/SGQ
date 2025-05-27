<?php

/**
 * PHPMaker 2024 configuration file (Production)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "amixxam.com", "port" => "3306", "user" => "wanderne_req", "password" => "DIpIYIp25O", "dbname" => "wanderne_sgq"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "email-ssl.com.br", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "sgq@amixxam.com.br", // SMTP server user name
        "SERVER_PASSWORD" => "#R11amixxam", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "4qTqXt1leaTIhPkJSIsnBgLtkecD3I69O+2dhuWJmQQ=", // JWT secret key
        "ALGORITHM" => "HS512", // JWT algorithm
        "AUTH_HEADER" => "X-Authorization", // API authentication header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
