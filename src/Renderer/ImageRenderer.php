<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class ImageRenderer extends Renderer
{
    public function render(): string
    {
        // @todo withBorder, withBackground, stretched options
        return <<<HTML
        <figure>
            <img src="{$this->data['file']['url']}" alt="">
            <figcaption>{$this->data['caption']}</figcaption>
        </figure>
        HTML;
    }
}
