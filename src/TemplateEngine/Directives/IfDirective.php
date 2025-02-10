<?php

namespace Parts\Core\TemplateEngine\Directives;

use Parts\Core\TemplateEngine\ExpressionResolver;

class IfDirective implements DirectiveInterface
{
    const IF_PATTERN = '/@if\((?<condition>.+?)\)/i';
    const ELSE_PATTERN = '/@else/i';
    const ENDIF_PATTERN = '/@endif/i';

    public function getName(): string
    {
        return 'if';
    }

    public function employ(string $template): string
    {
        $pattern = [
            self::IF_PATTERN => function ($match) {
                $condition = (new ExpressionResolver($match['condition']))->phpize();
                return "<?php if ($condition): ?>";
            },
            self::ELSE_PATTERN => function ($match) {
                return "<?php else: ?>";
            },
            self::ENDIF_PATTERN => function ($match) {
                return "<?php endif; ?>";
            }
        ];

        return preg_replace_callback_array($pattern, $template);
    }
}    