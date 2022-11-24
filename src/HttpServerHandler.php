<?php

declare(strict_types=1);

namespace PhpStandard\HttpServerHandler;

use PhpStandard\HttpServerHandler\Exceptions\MissingRequestHandlerException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @package PhpStandard\HttpServerHandler */
class HttpServerHandler implements RequestHandlerInterface
{
    /** @var array<MiddlewareInterface|RequestHandlerInterface> $queue */
    private array $queue;

    /**
     * @param array<MiddlewareInterface|RequestHandlerInterface> ...$queue
     * @return void
     */
    public function __construct(
        MiddlewareInterface|RequestHandlerInterface ...$queue
    ) {
        $this->queue = $queue;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (empty($this->queue)) {
            throw new MissingRequestHandlerException();
        }

        $entry = $this->queue[0];

        if ($entry instanceof MiddlewareInterface) {
            $handler = clone $this;
            $handler->queue = array_slice($this->queue, 1);

            return $entry->process($request, $handler);
        }

        return $entry->handle($request);
    }
}
