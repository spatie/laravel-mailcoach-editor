<?php

namespace Spatie\MailcoachEditor;

use Spatie\MailcoachEditor\Renderer\DelimiterRenderer;
use Spatie\MailcoachEditor\Renderer\HeaderRenderer;
use Spatie\MailcoachEditor\Renderer\ImageRenderer;
use Spatie\MailcoachEditor\Renderer\ListRenderer;
use Spatie\MailcoachEditor\Renderer\ParagraphRenderer;
use Spatie\MailcoachEditor\Renderer\QuoteRenderer;
use Spatie\MailcoachEditor\Renderer\RawRenderer;
use Spatie\MailcoachEditor\Renderer\TableRenderer;

class BlockRendererFactory
{
    public static function create(string $type, array $data): Renderer
    {
        return match($type) {
            'header' => new HeaderRenderer($data),
            'list' => new ListRenderer($data),
            'paragraph' => new ParagraphRenderer($data),
            'quote' => new QuoteRenderer($data),
            'raw' => new RawRenderer($data),
            'table' => new TableRenderer($data),
            'delimiter' => new DelimiterRenderer($data),
            'image' => new ImageRenderer($data),
        };
    }
}
