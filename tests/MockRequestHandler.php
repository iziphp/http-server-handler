<?php

declare(strict_types=1);

namespace PhpStandard\HttpServerHandler\Tests;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

/** @package PhpStandard\HttpServerHandler\Tests */
class MockRequestHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request 
     * @return ResponseInterface 
     * @throws RuntimeException 
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resp =  new Response();
        $resp->getBody()->write($request->getAttribute('value') ?: uniqid());
        return $resp;
    }
}
