<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class DelimiterRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        <hr>
        HTML;
    }
}
