<?php

namespace Antidot\Render\Phug\Container;

use Antidot\Render\Phug\Container\Config\PugConfig;
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
        $pugConfig = PugConfig::createFromAntidotConfig($container->get('config'));

        $pug = new Pug([
            'pugjs' => $pugConfig->get('pugjs'),
            'localsJsonFile' => $pugConfig->get('localsJsonFile'),
            'pretty' => $pugConfig->get('pretty'),
            'cache' => $pugConfig->get('cache'),
            'expressionLanguage' => $pugConfig->get('expressionLanguage'),
        ]);

        $this->addOns($pug, $container, $pugConfig);

        return $pug;
    }

    private function addOns(Pug $pug, ContainerInterface $container, PugConfig $config)
    {
        foreach (self::AVAILABLE_ADD_ONS as $method => $type) {
            foreach ($config->get($type) as $name => $callable) {
                $pug->{$method}($name, is_callable($callable) ? $callable : $container->get($callable));
            }
        }
    }
}
