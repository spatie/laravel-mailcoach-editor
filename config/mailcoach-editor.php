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

    /*
     * The disk on which to store uploaded images from the editor. Choose
     * one or more of the disks you've configured in config/filesystems.php.
     */
    'disk_name' => env('MEDIA_DISK', 'public'),
    
    /*
     * The media collection name to use when storing uploaded images from the editor.
     * You probably don't need to change this,
     * unless you're already using spatie/laravel-medialibrary in your project.
     */
     'collection_name' => env('MEDIA_COLLECTION', 'default'),

];
