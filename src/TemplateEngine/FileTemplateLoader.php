<?php

namespace Parts\Core\TemplateEngine;

use RuntimeException;
use Parts\Core\Utils\File;
use InvalidArgumentException;

class FileTemplateLoader implements TemplateLoaderInterface
{
    protected ?string $templatesBaseDir = null;

    public function __construct() { return $this; }

    public function setTemplatesBaseDir(string $baseDir): self
    {
        $this->templatesBaseDir = $baseDir;

        return $this;
    }

    public function load(string $template): string
    {
        if ($this->templatesBaseDir === null) {
            throw new InvalidArgumentException('No base directory set');
        }

        $templateFilePath = $this->buildTemplateFilePath($template);

        if (!File::exists($templateFilePath)) {
            throw new InvalidArgumentException("Template '$template' with path '$templateFilePath' not found");
        }

        return File::get($templateFilePath);
    }

    public function buildTemplateFilePath(string $template): string
    {
        return $this->templatesBaseDir . '/' . str_replace('.', '/', $template) . '.template.php';
    }
}