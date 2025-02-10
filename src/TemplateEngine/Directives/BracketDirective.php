<?php

namespace Parts\Core\TemplateEngine\Directives;

use Parts\Core\TemplateEngine\ExpressionResolver;

class BracketDirective implements DirectiveInterface
{
    const BRACKET_PATTERN = '/{{ (?<expression>.+?) }}/i';

    public function getName(): string
    {
        return 'bracket';
    }

    public function employ(string $template): string
    {
        $callback = function ($matches) {
            $phpizedExpression = (new ExpressionResolver($matches['expression']))->phpize();
            return "<?= $phpizedExpression ?>";
        };

        return preg_replace_callback(self::BRACKET_PATTERN, $callback, $template);
    }
}    