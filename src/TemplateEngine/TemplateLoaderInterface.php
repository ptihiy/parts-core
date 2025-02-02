<?php

namespace Parts\Core\TemplateEngine;

interface TemplateLoaderInterface
{
    public function load(string $template): string;
}