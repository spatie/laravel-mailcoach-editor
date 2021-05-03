<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class HeaderRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        <h{$this->data['level']}>{$this->data['text']}</h{$this->data['level']}>
        HTML;
    }
}
