<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//phpinfo(); 

/*
 * index.php
 * 
 * Copyright 2025 Administrator <administrator@internal.systematicdefence.tech@nzj-dev-ubuntu22>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use DI\Container;
use api_server2\ServiceContainer;
use api_server2\MyService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/ServiceContainer.php';
require_once __DIR__ . '/MyService.php';
//require_once __DIR__ . '/Logger.php';

$c1 = new Container();

$c1->set('Slim\Error\Renderers\PlainTextErrorRenderer', function() {
		return new \Slim\Error\Renderers\PlainTextErrorRenderer();
	});


$c1->set('logger', function() {
		$logger = new \Monolog\Logger('api_logger');
		$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/logs/app.log', \Monolog\Logger::DEBUG));
		return $logger;
	});

$c1->set('myService', function($c1) {
		return new \api_server2\MyService($c1->get('logger'));
	});

AppFactory::SetContainer($c1);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

// Add the RoutingMiddleware before the CORS middleware
// to ensure routing is performed later
$app->addRoutingMiddleware();

// Add the ErrorMiddleware before the CORS middleware
// to ensure error responses contain all CORS headers.
$app->addErrorMiddleware(true, true, true);

// This CORS middleware will append the response header
// Access-Control-Allow-Methods with all allowed methods
$app->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($app): ResponseInterface {
    if ($request->getMethod() === 'OPTIONS') {
        $response = $app->getResponseFactory()->createResponse();
    } else {
        $response = $handler->handle($request);
    }

    $response = $response
        ->withHeader('Access-Control-Allow-Credentials', 'true')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
        ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->withHeader('Pragma', 'no-cache');

    if (ob_get_contents()) {
        ob_clean();
    }

    return $response;
});

// Define app routes
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) use ($c1){
    $response->getBody()->write('Hello, World!');
    $service=$c1->get('myService');
    //var_dump($service); exit;
    $service->doSomething();
    return $response;
});

// ...

$app->run();
