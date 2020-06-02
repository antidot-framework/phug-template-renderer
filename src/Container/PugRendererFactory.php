<?php

namespace Antidot\Render\Phug\Container;

use Antidot\Render\Phug\Container\Config\PugConfig;
use Antidot\Render\Phug\PugTemplateRenderer;
use Antidot\Render\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Pug\Pug;

class PugRendererFactory
{
    public function __invoke(ContainerInterface $container): TemplateRenderer
    {
        $pugConfig = PugConfig::createFromAntidotConfig($container->get('config'));

        return new PugTemplateRenderer(
            $container->get(Pug::class),
            $pugConfig->get('default_params'),
            $pugConfig->get('globals'),
            array_merge(
                $pugConfig->templates(),
                [
                    'template_path' => $pugConfig->get('template_path')
                ]
            )
        );
    }
}
