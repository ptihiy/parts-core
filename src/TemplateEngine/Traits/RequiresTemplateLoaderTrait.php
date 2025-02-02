<?php

namespace Parts\Core\TemplateEngine\Traits;

use Parts\Core\TemplateEngine\TemplateLoaderInterface;

trait RequiresTemplateLoaderTrait
{
    public function __construct(
        protected TemplateLoaderInterface $loader
    ) {}
}