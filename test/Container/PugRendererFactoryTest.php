<?php

declare(strict_types=1);


namespace AntidotTest\Render\Phug\Container;

use Antidot\Render\Phug\Container\PugRendererFactory;
use Antidot\Render\TemplateRenderer;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Pug\Pug;

class PugRendererFactoryTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->container->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(['config'], [Pug::class])
            ->willReturnOnConsecutiveCalls([], $this->createMock(Pug::class));
    }

    public function testItShouldCreateInstanceOfPugTemplateRenderer(): void
    {
        $pugRendererFactory = new PugRendererFactory();
        $pugRenderer = $pugRendererFactory->__invoke($this->container);

        $this->assertInstanceOf(TemplateRenderer::class, $pugRenderer);
    }
}
