<?php

namespace Parts\Core\TemplateEngine;

interface TemplateEngineInterface
{
    public function renderInline(string $template, array $data = []): string;
}