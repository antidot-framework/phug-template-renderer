<?php

declare(strict_types=1);

namespace Antidot\Render\Phug\Container;

use Antidot\Render\Phug\Container\Config\PugConfig;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PugFactoryTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;

    public function setUp(): void
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
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG['cache'], $pug->getOption('cache'));
        $this->assertEquals(PugConfig::DEFAULT_PUG_CONFIG['expressionLanguage'], $pug->getOption('expressionLanguage'));
    }
}
