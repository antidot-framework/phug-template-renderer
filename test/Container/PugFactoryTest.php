<?php

declare(strict_types=1);

namespace AntidotTest\Render\Phug\Container;

use Antidot\Render\Phug\Container\PugFactory;
use Antidot\Render\Phug\Container\Config\PugConfig;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PugFactoryTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([]);
    }

    public function testItShouldCreateConfiguredPugInstances(): void
    {
        $factory = new PugFactory();
        $pug = $factory->__invoke($this->container);
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG['pugjs'], $pug->getOption('pugjs'));
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG['localsJsonFile'], $pug->getOption('localsJsonFile'));
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG['pretty'], $pug->getOption('pretty'));
        $this->assertSame(PugConfig::DEFAULT_PUG_CONFIG['cache'], $pug->getOption('cache'));
        $this->assertSame(PugConfig::DEFAULT_PUG_CONFIG['expressionLanguage'], $pug->getOption('expressionLanguage'));
    }
}
