<?php
require __DIR__ . '/../../vendor/autoload.php';

use OpenApi\Generator;

$generator = new Generator();
$openapi = $generator->generate([__DIR__ . '/../Controllers']);
header('Content-Type: application/json');
echo $openapi->toJson();
