<?php

namespace Parts\Core;

use Parts\Core\Container\Container;
use Parts\Core\Container\ContainerInterface;
use Parts\Core\Request\Request;
use Parts\Core\Request\RequestInterface;

class Kernel
{
    protected ?ContainerInterface $container;

    public function __construct(protected RequestInterface $request)
    {
        $this->container = new Container();
        $this->container->set(RequestInterface::class, $request);
    }
    
    public function start()
    {
        return 'success';
    }
}

