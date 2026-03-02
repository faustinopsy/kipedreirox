<?php
namespace App\Kipedreiro\Controllers;

use OpenApi\Generator;

class SwaggerController
{
    public function docs()
    {
        require_once dirname(__DIR__) . '/Views/swagger/index.php';
    }

    public function json()
    {
        require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
        
        $generator = new Generator();
        $openapi = $generator->generate([__DIR__]);
        header('Content-Type: application/json');
        echo $openapi->toJson();
        exit;
    }
}
