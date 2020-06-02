<?php

declare(strict_types=1);

namespace AntidotTest\Render\Phug\Container\Config;

use Antidot\Render\Phug\Container\Config\PugConfig;
use PHPUnit\Framework\TestCase;

class PugConfigTest extends TestCase
{
    private const BASIC_CONFIG = [
    ];
    /** @var PugConfig */
    private $pugConfig;

    public function setUp(): void
    {
        $this->pugConfig = PugConfig::createFromAntidotConfig(self::BASIC_CONFIG);
    }

    public function testItShouldCreatePhugConfigFromAntidotConfigArray(): void
    {
        $this->pugConfig = PugConfig::createFromAntidotConfig(self::BASIC_CONFIG);
        $this->assertEquals($this->pugConfig->templates(), PugConfig::DEFAULT_TEMPLATE_CONFIG);
        foreach (PugConfig::DEFAULT_PUG_CONFIG as $key => $value) {
            $this->assertEquals($value, $this->pugConfig->get($key));
        }
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG, $this->pugConfig->jsonSerialize());
    }

    public function testItShouldThrowAnExceptionWhenCallingInExistentConfigKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->pugConfig->get('invalid_key');
    }
}
