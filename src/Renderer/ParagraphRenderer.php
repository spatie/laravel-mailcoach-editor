<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class ParagraphRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        <p>{$this->data['text']}</p>
        HTML;
    }
}
