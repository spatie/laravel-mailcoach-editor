<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class ListRenderer extends Renderer
{
    public function render(): string
    {
        $tag = $this->data['style'] === 'ordered' ? 'ol' : 'ul';
        $items = collect($this->data['items'])->map(function (string $item) {
            return "<li>{$item}</li>";
        })->join("\n");

        return <<<HTML
        <{$tag}>
            {$items}
        </{$tag}>
        HTML;
    }
}
