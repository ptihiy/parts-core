<?php

namespace Parts\Core\TemplateEngine\Directives;

use Parts\Core\TemplateEngine\Traits\RequiresTemplateLoaderTrait;

class IncludeDirective implements DirectiveInterface
{
    const INCLUDE_PATTERN = '/@include\(\'(?<name>.+?)\'\)/i';
    
    use RequiresTemplateLoaderTrait;

    public function getName(): string
    {
        return 'include';
    }

    public function employ(string $template): string
    {
        $callback = function ($matches) {
            return $this->loader->load($matches['name']);
        };

        while (preg_match(self::INCLUDE_PATTERN, $template)) {
            $template = preg_replace_callback(self::INCLUDE_PATTERN, $callback, $template);
        }


        return $template;
    }
}    