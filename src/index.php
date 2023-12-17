<?php

use src\core\Schema;

require_once __DIR__ . '/../vendor/autoload.php';

// USAGE EXAMPLE
$dataSchema = [
    "id" => ["string", "required"],
    "username" => ["string", "required", "minLen: 3", "maxLen: 16"],
    "avatar_url" => ["string", "optional"],
];

$data = [
    "id" => "dawdadawd",
    "username" => "dwadawdaw"
];

try {
    $schema = new Schema();
    $body = $schema->validate(schema: $dataSchema, data: $data);
    var_dump($body);
} catch (Exception $except) {
    //$execept->getMessage() return the first error from validate errors
}

