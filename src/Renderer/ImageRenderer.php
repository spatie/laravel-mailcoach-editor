<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class ImageRenderer extends Renderer
{
    public function render(): string
    {
        // @todo withBorder, withBackground, stretched options
        return <<<HTML
        <div>
            <img src="{$this->data['file']['url']}" alt="">
            <p>{$this->data['caption']}</p>
        </div>
        HTML;
    }
}
