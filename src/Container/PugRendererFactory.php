<?php

namespace Antidot\Render\Phug\Container;

use Antidot\Render\Phug\PugTemplateRenderer;
use Antidot\Render\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Pug\Pug;

class PugRendererFactory
{
    public function __invoke(ContainerInterface $container): TemplateRenderer
    {
        $config = $container->get('config');

        return new PugTemplateRenderer(
            $container->get(Pug::class),
            $config['pug']['default_params'],
            $config['pug']['globals'],
            array_merge(
                $config['templates'],
                [
                    'template_path' => $config['pug']['template_path']
                ]
            )
        );
    }
}
