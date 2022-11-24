<?php

namespace PhpStandard\HttpServerHandler\Tests;

use Laminas\Diactoros\ServerRequestFactory;
use PhpStandard\HttpServerHandler\HttpServerHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

class HttpServerHandlerTest extends TestCase
{
    /** @test */
    public function isImplementingRequestHandlerInterface()
    {
        $handler = new HttpServerHandler();
        $this->assertInstanceOf(RequestHandlerInterface::class, $handler);
    }

    /** @test */
    public function isProcessingMiddlewares()
    {
        $factory = new ServerRequestFactory();
        $req = $factory->createServerRequest('GET', '/');

        $values = [uniqid(), uniqid(), uniqid()];
        $stack = [];

        foreach ($values as $val) {
            $stack[] = new MockMiddleware($val);
        }
        $stack[] = new MockRequestHandler();

        $handler = new HttpServerHandler(...$stack);
        $resp = $handler->handle($req);

        $resp->getBody()->rewind();

        $responseValue = $resp->getBody()->getContents();
        $this->assertEquals(end($values), $responseValue);
    }
}
