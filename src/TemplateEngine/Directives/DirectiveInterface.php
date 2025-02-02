<?php

namespace Parts\Core\TemplateEngine\Directives;

interface DirectiveInterface
{
    public function getName(): string;

    public function employ(string $template): string;
}