<?php

namespace Parts\Core\TemplateEngine;

interface TemplateEngineInterface
{
    public function renderInline(string $template, array $data = []): string;

    public function render(string $templateName, array $data = []): string;
}