<?php

namespace Parts\Core\Request;

class Request implements RequestInterface
{
    const METHOD_GET = 'GET';

    public function __construct(
        protected $server = [],
        protected $get = [],
        protected $post = [],
        protected $files = [],
        protected $cookies = [],
        protected $env = []
    )
    {
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? self::METHOD_GET;
    }

    public function getUrl(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }
}