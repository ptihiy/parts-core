<?php

namespace Parts\Core\TemplateEngine;

use Parts\Core\TemplateEngine\Directives\BracketDirective;
use Parts\Core\Utils\Reflection;
use Parts\Core\TemplateEngine\Directives\ExtendsDirective;
use Parts\Core\TemplateEngine\Directives\ForeachDirective;
use Parts\Core\TemplateEngine\Directives\IfDirective;
use Parts\Core\TemplateEngine\Directives\IncludeDirective;
use Parts\Core\TemplateEngine\Traits\RequiresTemplateLoaderTrait;

class TemplateEngine implements TemplateEngineInterface
{
    protected array $preprocessorIds = [
        ExtendsDirective::class,
        IncludeDirective::class,
        IfDirective::class,
        ForeachDirective::class,
        BracketDirective::class
    ];

    protected array $globalVars = [];

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

    public function addGlobalVar(string $name, $value): void
    {
        $this->globalVars[$name] = $value;
    }

    public function renderInline(string $template, array $data = []): string
    {
        $template = $this->preprocess($template);

        $uniqueFilename = tempnam(sys_get_temp_dir(), 'tmp_');
        file_put_contents($uniqueFilename, $template);

        extract(array_merge($this->globalVars, $data));

        ob_start();
        
        require $uniqueFilename;

        $output = ob_get_clean();

        return $output;
    }

    public function render(string $template, array $data = []): string
    {
        return $this->renderInline($this->loader->load($template), $data);
    }    
}