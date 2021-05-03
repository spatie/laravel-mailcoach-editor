<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class QuoteRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        <blockquote style="text-align: {$this->data['alignment']}">
            {$this->data['text']}<br>
            {$this->data['caption']}
        </blockquote>
        HTML;
    }
}
