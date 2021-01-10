<?php

declare(strict_types=1);

namespace Antidot\Render\Phug\Container\Config;

use InvalidArgumentException;
use JsonSerializable;
use function array_key_exists;
use function array_merge;
use function array_replace_recursive;
use function sprintf;

class PugConfig implements JsonSerializable
{
    public const DEFAULT_PUG_CONFIG = [
        'pretty' => true,
        'expressionLanguage' => 'js',
        'pugjs' => false,
        'localsJsonFile' => false,
        'cache' => 'var/cache/pug',
        'template_path' => 'templates/',
        'globals' => [],
        'filters' => [],
        'keywords' => [],
        'helpers' => [],
        'default_params' => [],
    ];
    public const DEFAULT_TEMPLATE_CONFIG = [
        'extension' => 'pug',
    ];
    /** @var array<mixed>  */
    private $config;
    /** @var array<string>  */
    private $templates;

    /**
     * @param array<mixed> $config
     * @param array<string> $templates
     */
    private function __construct(array $config, array $templates)
    {
        $this->config = $config;
        $this->templates = $templates;
    }

    /**
     * @param array<mixed> $config
     */
    public static function createFromAntidotConfig(array $config): self
    {
        $templates = self::DEFAULT_TEMPLATE_CONFIG;
        $pugConfig = self::DEFAULT_PUG_CONFIG;

        if (array_key_exists('templates', $config)) {
            $templates = array_merge($templates, $config['templates']);
        }

        if (array_key_exists('pug', $config)) {
            $pugConfig = $config['pug'];
        }

        if (array_key_exists('templating', $config)) {
            $pugConfig = array_replace_recursive($pugConfig, $config['templating']);
        }

        return new self($pugConfig, $templates);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if (false === array_key_exists($key, $this->config)) {
            throw new InvalidArgumentException(sprintf(
                'Missing key "%s" in pug template config',
                $key
            ));
        }

        return $this->config[$key];
    }

    /**
     * @return array<mixed>
     */
    public function templates(): array
    {
        return $this->templates;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->config;
    }
}
