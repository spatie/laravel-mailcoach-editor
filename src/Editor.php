<?php

namespace Spatie\MailcoachEditor;

use Spatie\Mailcoach\Domain\Campaign\Models\Concerns\HasHtmlContent;
use Spatie\Mailcoach\Domain\Campaign\Models\Template;
use Spatie\Mailcoach\Domain\Shared\Support\Editor\Editor as AbstractEditor;
use Spatie\Mailcoach\Domain\TransactionalMail\Models\TransactionalMailTemplate;

class Editor implements AbstractEditor
{
    public function render(HasHtmlContent $model): string
    {
        $structured_html = json_decode($model->getStructuredHtml(), true);
        $body = $structured_html['body'] ?? '';
        $template = $structured_html['template'] ?? view('mailcoach-editor::template')->render();

        return view('mailcoach-editor::editor', [
            'html' => $model->getHtml(),
            'body' => $body,
            'template' => $template,
            'model' => $model,
            'showTestButton' => ! $model instanceof Template && ! $model instanceof TransactionalMailTemplate,
        ])->render();
    }

    public static function renderBlocks(array $blocks, string $template): string
    {
        $html = "";
        foreach ($blocks as $block) {
            $rendererClass = config("mailcoach-editor.renderers.{$block['type']}");

            if ($rendererClass && is_subclass_of($rendererClass, Renderer::class)) {
                $renderer = new $rendererClass($block['data']);
                $html .= $renderer->render();
                $html .= "\n";
            }
        }

        // Replace this in the generated html as Editor.js likes to automatically add the protocol to links
        $html = str_replace('http://::', '::', $html);

        return str_replace('::content::', $html, $template);
    }
}
