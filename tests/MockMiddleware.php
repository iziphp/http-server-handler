<?php

declare(strict_types=1);

namespace PhpStandard\HttpServerHandler\Tests;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @package PhpStandard\HttpServerHandler\Tests */
class MockMiddleware implements MiddlewareInterface
{
    public function __construct(private string $randomValue)
    {
    }

    /**
     * @param ServerRequestInterface $request 
     * @param RequestHandlerInterface $handler 
     * @return ResponseInterface 
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $handler->handle(
            $request->withAttribute('value', $this->randomValue)
        );
    }
}
