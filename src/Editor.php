<?php

namespace Spatie\MailcoachEditor;

use Spatie\Mailcoach\Domain\Campaign\Models\Concerns\HasHtmlContent;
use Spatie\Mailcoach\Domain\Shared\Support\Editor\Editor as AbstractEditor;

class Editor implements AbstractEditor
{
    public function render(HasHtmlContent $model): string
    {
        return view('mailcoach-editor::editor', [
            'html' => $model->getHtml(),
            'structured_html' => $model->getStructuredHtml(),
            'model' => $model,
        ])->render();
    }
}
