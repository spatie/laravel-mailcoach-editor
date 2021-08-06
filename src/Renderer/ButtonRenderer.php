<?php

namespace Spatie\MailcoachEditor\Renderer;

use Highlight\Highlighter;
use function HighlightUtilities\getStyleSheet;
use Spatie\MailcoachEditor\Renderer;

class ButtonRenderer extends Renderer
{
    public function render(): string
    {
        return <<<HTML
        <table class="btn btn-primary" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td align="center">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td>
                                            <a href="{$this->data['url']}" class="button button-primary" target="_blank" rel="noopener">{$this->data['text']}</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        HTML;
    }
}
