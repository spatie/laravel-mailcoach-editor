<?php

namespace Spatie\MailcoachEditor\Tests;

use Spatie\Mailcoach\Domain\Campaign\Models\Template;
use Spatie\MailcoachEditor\EditorEditor;

class EditorEditorTest extends TestCase
{
    /** @test * */
    public function it_renders_a_view()
    {
        $editor = new EditorEditor();

        $template = Template::factory()->create();

        $html = $editor->render($template);

        $this->assertStringContainsString('input type="hidden" name="html"', $html);
        $this->assertStringContainsString('input type="hidden" name="structured_html"', $html);
    }

    /** @test * */
    public function test_passes_along_configured_options()
    {
        config(['mailcoach.editor.options' => [
            'appearance' => ['theme' => 'dark']
        ]]);

        $editor = new EditorEditor();

        $template = Template::factory()->create();

        $html = $editor->render($template);

        $this->assertStringContainsString('appearance', $html);
        $this->assertStringContainsString('dark', $html);
    }
}
