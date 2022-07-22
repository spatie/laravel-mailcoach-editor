<?php

return [
    /**
     * Here you can configure the supported block
     * type renderers for the Editor.js blocks.
     */
    'renderers' => [
        'header' => \Spatie\MailcoachEditor\Renderer\HeaderRenderer::class,
        'list' => \Spatie\MailcoachEditor\Renderer\ListRenderer::class,
        'paragraph' => \Spatie\MailcoachEditor\Renderer\ParagraphRenderer::class,
        'quote' => \Spatie\MailcoachEditor\Renderer\QuoteRenderer::class,
        'raw' => \Spatie\MailcoachEditor\Renderer\RawRenderer::class,
        'table' => \Spatie\MailcoachEditor\Renderer\TableRenderer::class,
        'delimiter' => \Spatie\MailcoachEditor\Renderer\DelimiterRenderer::class,
        'image' => \Spatie\MailcoachEditor\Renderer\ImageRenderer::class,
        'code' => \Spatie\MailcoachEditor\Renderer\CodeRenderer::class,
        'button' => \Spatie\MailcoachEditor\Renderer\ButtonRenderer::class,
    ],
];
