<?php

namespace Parts\Core\Request;

interface RequestInterface
{
    public function getMethod(): string;

    public function getUrl(): string;
}