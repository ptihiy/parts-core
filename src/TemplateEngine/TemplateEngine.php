<?php

namespace Parts\Core\TemplateEngine;

use Parts\Core\Utils\Reflection;
use Parts\Core\TemplateEngine\Directives\ExtendsDirective;
use Parts\Core\TemplateEngine\Directives\IncludeDirective;
use Parts\Core\TemplateEngine\Traits\RequiresTemplateLoaderTrait;

class TemplateEngine implements TemplateEngineInterface
{
    const EXTENDS_PATTERN = '/@extends\(\'(.+?)\'\)/i';
    const SECTION_PATTERN = '/@section\(\'(?<name>.+?)\'\)(?<contents>.+?)?@endsection/i';

    protected array $preprocessorIds = [
        ExtendsDirective::class,
        IncludeDirective::class
    ];

    public function preprocess(string $template): string
    {
        foreach ($this->preprocessorIds as $preprocessorId) {
            $preprocessor = Reflection::usesTrait($preprocessorId, RequiresTemplateLoaderTrait::class) 
                ? new $preprocessorId($this->loader) 
                : new $preprocessorId();   

            $template = $preprocessor->employ($template);
        }

        return $template;
    }

    public function __construct(
        private TemplateLoaderInterface $loader
    ) {}

    public function renderInline(string $template, array $data = []): string
    {
        $template = $this->preprocess($template);

        $template = $this->replaceBrackets($template, $data);

        return $template;
    }

    protected function replaceBrackets($template, array $data)
    {
        $pattern = '/\{\{ (.+?) \}\}/i';
        $callback = function ($matches) use ($data) {
            return $data[$matches[1]] ?? '';
        };

        return preg_replace_callback($pattern, $callback, $template);
    }

    public function render(string $template, array $data = []): string
    {
        return $this->renderInline($this->loader->load($template), $data);
    }    
}