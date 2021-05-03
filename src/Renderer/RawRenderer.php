<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class RawRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        {$this->data['html']}
        HTML;
    }
}
