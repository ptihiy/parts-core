<?php

namespace Parts\Core\TemplateEngine;

class ExpressionResolver
{
    protected array $reservedWords = ['true', 'false'];

    public function __construct(protected string $expression)
    {}

    public function phpize(): string
    {
        if (in_array($this->expression, $this->reservedWords)) {
            return $this->expression;
        }

        if (strpos($this->expression, '.') !== false) {
            $this->expression = "" . str_replace('.', "['", $this->expression) . "']";
        }

        return '$' . $this->expression;
    }
}