<?php

namespace Antidot\Render\Phug\Container\Config;

use Antidot\Render\Phug\Container\PugFactory;
use Antidot\Render\Phug\Container\PugRendererFactory;
use Antidot\Render\TemplateRenderer;
use Pug\Pug;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => PugConfig::DEFAULT_TEMPLATE_CONFIG,
            'pug' => PugConfig::DEFAULT_PUG_CONFIG,
        ];
    }

    protected function getDependencies()
    {
        return [
            'factories' => [
                Pug::class => PugFactory::class,
                TemplateRenderer::class => PugRendererFactory::class,
            ]
        ];
    }
}
