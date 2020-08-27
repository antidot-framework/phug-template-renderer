<?php

declare(strict_types=1);


namespace AntidotTest\Render\Phug;

use Antidot\Render\Phug\PugTemplateRenderer;
use Antidot\Render\Phug\Container\Config\PugConfig;
use PHPUnit\Framework\TestCase;
use Pug;

class PugTemplateRendererTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|Pug */
    private $pug;

    protected function setUp(): void
    {
        $this->pug = $this->createMock(Pug::class);
    }

    public function testItShouldRenderTemplate(): void
    {
        $renderer = new PugTemplateRenderer(
            $this->pug,
            PugConfig::DEFAULT_PUG_CONFIG['default_params'],
            PugConfig::DEFAULT_PUG_CONFIG['globals'],
            array_merge(
                PugConfig::DEFAULT_TEMPLATE_CONFIG,
                ['template_path' => PugConfig::DEFAULT_PUG_CONFIG['template_path']]
            )
        );

        $this->pug->expects($this->once())
            ->method('render')
            ->with('templates/app/index.pug', ['name' => 'Koldo'])
            ->willReturn('');
        $renderer->render('app::index', ['name' => 'Koldo']);
    }
}
