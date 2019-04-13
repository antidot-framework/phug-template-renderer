<?php

namespace Antidot\Render\Phug\Container;

use Psr\Container\ContainerInterface;
use Pug\Pug;

final class PugFactory
{
    public const AVAILABLE_ADD_ONS = [
        'filter' => 'filters',
        'addKeyword' => 'keywords',
        'share' => 'helpers',
    ];

    public function __invoke(ContainerInterface $container): Pug
    {
        $config = $container->get('config')['pug'];

        $pug = new Pug([
            'pugjs' => $config['pugjs'],
            'localsJsonFile' => $config['localsJsonFile'],
            'pretty' => $config['pretty'],
            'cache' => $config['cache'],
            'expressionLanguage' => $config['expressionLanguage'],
        ]);

        $this->addOns($pug, $container, $config);

        return $pug;
    }

    private function addOns(Pug $pug, ContainerInterface $container, array $config)
    {
        foreach (self::AVAILABLE_ADD_ONS as $method => $type) {
            array_walk($config[$type], function ($callable, $name) use ($method, $pug, $container) {
                $pug->{$method}($name, is_callable($callable) ? $callable : $container->get($callable));
            });
        }
    }
}
