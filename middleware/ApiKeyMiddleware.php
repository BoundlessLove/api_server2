<?php
// src/Middleware/ApiKeyMiddleware.php

namespace api_server2\middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Psr7\Response;

class ApiKeyMiddleware implements MiddlewareInterface
{
    private string $validApiKey;

    public function __construct(string $validApiKey)
    {
        $this->validApiKey = $validApiKey;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $apiKey = $request->getHeaderLine('x-api-key');

        if ($apiKey !== $this->validApiKey) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Unauthorized']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}
