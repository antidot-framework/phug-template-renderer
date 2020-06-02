<?php

declare(strict_types=1);

namespace AntidotTest\Render\Phug\Container\Config;

use Antidot\Render\Phug\Container\Config\PugConfig;
use PHPUnit\Framework\TestCase;

class PugConfigTest extends TestCase
{
    private const BASIC_CONFIG = [
    ];
    private const TITLE = 'Some Title';
    private const OTHER_TITLE = 'Some Other Title';
    private const EXTENSION = 'html.pug';
    private const PUG_CONFIG = [
        'templates' => [
            'extension' => self::EXTENSION,
        ],
        'pug' => [
            'globals' => [
                'title' => self::TITLE,
            ],
        ],
    ];
    private const TEMPLATING_CONFIG = [
        'templating' => [
            'globals' => [
                'title' => self::OTHER_TITLE,
            ],
        ],
    ];

    public function testItShouldCreatePhugConfigFromAntidotConfigArray(): void
    {
        $pugConfig = PugConfig::createFromAntidotConfig(self::BASIC_CONFIG);
        $this->assertEquals($pugConfig->templates(), PugConfig::DEFAULT_TEMPLATE_CONFIG);
        foreach (PugConfig::DEFAULT_PUG_CONFIG as $key => $value) {
            $this->assertEquals($value, $pugConfig->get($key));
        }
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG, $pugConfig->jsonSerialize());
    }

    public function testItShouldMergeDefaultConfigWithUserGivenConfig(): void
    {
        $pugConfig = PugConfig::createFromAntidotConfig(self::PUG_CONFIG);
        $this->assertEquals(self::TITLE, $pugConfig->get('globals')['title']);
        $this->assertEquals(self::EXTENSION, $pugConfig->templates()['extension']);
    }

    public function testItShouldMergeDefaultConfigWithUserGivenConfigAndTemplatingConfigShouldOverridePugConfig(): void
    {
        $pugConfig = PugConfig::createFromAntidotConfig(array_merge(self::TEMPLATING_CONFIG, self::PUG_CONFIG));
        $this->assertEquals(self::OTHER_TITLE, $pugConfig->get('globals')['title']);
        $this->assertEquals(self::EXTENSION, $pugConfig->templates()['extension']);
    }

    public function testItShouldThrowAnExceptionWhenCallingInExistentConfigKey(): void
    {
        $pugConfig = PugConfig::createFromAntidotConfig(self::BASIC_CONFIG);
        $this->expectException(\InvalidArgumentException::class);
        $pugConfig->get('invalid_key');
    }
}
