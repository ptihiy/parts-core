<?php

namespace Parts\Core\TemplateEngine\Directives;

use Parts\Core\TemplateEngine\Traits\RequiresTemplateLoaderTrait;

class ExtendsDirective implements DirectiveInterface
{
    const EXTENDS_PATTERN = '/@extends\(\'(.+?)\'\)/i';
    const SECTION_PATTERN = '/@section\(\'(?<name>.+?)\'\)(?<contents>.+?)?@endsection/is';

    use RequiresTemplateLoaderTrait;

    public function getName(): string
    {
        return 'extends';
    }

    public function employ(string $template): string
    {
        if (!preg_match(self::EXTENDS_PATTERN, $template, $matches)) {
            return $template;
        }

        $templateToExtend = $this->loader->load($matches[1]);

        preg_match_all(self::SECTION_PATTERN, $template, $sectionMatches);

        $sections = [];
        foreach ($sectionMatches['name'] as $index => $sectionName) {
            $sections[$sectionName] = $sectionMatches['contents'][$index];
        }

        $callback = function ($matches) use ($sections) {
            if (array_key_exists($matches['name'], $sections)) {
                return $sections[$matches['name']];
            }
            return $matches[0];
        };

        return preg_replace_callback(self::SECTION_PATTERN, $callback, $templateToExtend);
    }
}    