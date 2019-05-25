<?php

namespace Antidot\Render\Phug;

use Antidot\Render\TemplateRenderer;
use Pug\Pug;

use function array_merge_recursive;
use function sprintf;
use function str_replace;

class PugTemplateRenderer implements TemplateRenderer
{
    public const DEFAULT_PATH = 'templates/';

    /**
     * @var Pug
     */
    private $pug;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $globals;

    /**
     * @var array
     */
    private $config;

    public function __construct(Pug $pug, array $defaultParams, array $globals, array $config)
    {
        $this->pug = $pug;
        $this->globals = $globals;
        $this->config = $config;
        $this->addPath($this->config['template_path']);
        $this->setDefaultParams($defaultParams);
    }

    private function setDefaultParams(array $defaultParams): void
    {
        foreach ($defaultParams as $name => $params) {
            if (empty($this->globals[$name])) {
                $this->globals[$name] = [];
            }
            foreach ($params as $param => $value) {
                $this->globals[$name][$param] = $value;
            }
        }
    }

    /**
     * @param string $name
     * @param array $params
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
     *
     * @param string $path
     */
    public function addPath(string $path) : void
    {
        $this->path = $path ?: self::DEFAULT_PATH;
    }
}
