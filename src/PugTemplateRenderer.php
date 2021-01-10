<?php

declare(strict_types=1);

namespace Antidot\Render\Phug;

use Antidot\Render\TemplateRenderer;
use Pug\Pug;

use function array_replace_recursive;
use function array_merge_recursive;
use function sprintf;
use function str_replace;

class PugTemplateRenderer implements TemplateRenderer
{
    public const DEFAULT_PATH = 'templates/';
    /** @var Pug */
    private $pug;
    /** @var string */
    private $path;
    /** @var array<mixed> */
    private $globals;
    /** @var array<mixed> */
    private $config;

    /**
     * PugTemplateRenderer constructor.
     * @param Pug $pug
     * @param array<mixed> $defaultParams
     * @param array<mixed> $globals
     * @param array<mixed> $config
     */
    public function __construct(Pug $pug, array $defaultParams, array $globals, array $config)
    {
        $this->pug = $pug;
        $this->globals = $globals;
        $this->config = $config;
        $this->addPath($this->config['template_path']);
        $this->setDefaultParams($defaultParams);
    }

    /**
     * @param array<mixed> $defaultParams
     */
    private function setDefaultParams(array $defaultParams): void
    {
        $this->globals = (array) array_replace_recursive($this->globals, $defaultParams);
    }

    /**
     * @param string $name
     * @param array<mixed> $params
     * @return string
     */
    public function render(string $name, array $params = []) : string
    {
        return $this->pug->render(
            sprintf(
                '%s.%s',
                $this->path . str_replace('::', '/', $name),
                $this->config['extension']
            ),
            array_merge_recursive($this->globals, $params)
        );
    }

    /**
     * Add a template path to the engine.
     *
     * Adds a template path
     */
    private function addPath(?string $path) : void
    {
        $this->path = $path ?: self::DEFAULT_PATH;
    }
}
