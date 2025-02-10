<?php

namespace Parts\Core\TemplateEngine\Directives;

use Parts\Core\TemplateEngine\ExpressionResolver;

class ForeachDirective implements DirectiveInterface
{
    const FOREACH_PATTERN = '/@foreach\((?<variable1>.+?) as (?<variable2>.+?)\)/i';
    const ENDFOREACH_PATTERN = '/@endforeach/i';

    public function getName(): string
    {
        return 'foreach';
    }

    public function employ(string $template): string
    {
        $pattern = [
            self::FOREACH_PATTERN => function ($match) {
                $variable1 = (new ExpressionResolver($match['variable1']))->phpize();
                $variable2 = (new ExpressionResolver($match['variable2']))->phpize();
                return "<?php foreach ($variable1 as $variable2): ?>";
            },
            self::ENDFOREACH_PATTERN => function ($match) {
                return "<?php endforeach; ?>";
            }
        ];

        return preg_replace_callback_array($pattern, $template);
    }
}    