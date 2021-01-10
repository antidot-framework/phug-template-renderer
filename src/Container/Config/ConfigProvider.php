<?php

namespace Antidot\Render\Phug\Container\Config;

use Antidot\Render\Phug\Container\PugFactory;
use Antidot\Render\Phug\Container\PugRendererFactory;
use Antidot\Render\TemplateRenderer;
use Pug\Pug;

class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => PugConfig::DEFAULT_TEMPLATE_CONFIG,
            'pug' => PugConfig::DEFAULT_PUG_CONFIG,
        ];
    }

    /**
     * @return array<array<string, string>>
     */
    protected function getDependencies(): array
    {
        return [
            'factories' => [
                Pug::class => PugFactory::class,
                TemplateRenderer::class => PugRendererFactory::class,
            ]
        ];
    }
}
