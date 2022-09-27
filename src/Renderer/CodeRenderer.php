<?php

namespace Spatie\MailcoachEditor\Renderer;

use Highlight\Highlighter;

use function HighlightUtilities\getStyleSheet;

use Spatie\MailcoachEditor\Renderer;

class CodeRenderer extends Renderer
{
    public function render(): string
    {
        $hl = new Highlighter();

        if (isset($this->data['language'])) {
            $highlighted = $hl->highlight($this->data['language'], $this->data['code']);
        } else {
            $highlighted = $hl->highlightAuto($this->data['code']);
        }

        $style = '';
        if (session()->get('included-code-theme')) {
            $style = getStyleSheet($this->data['theme'] ?? 'github');
            session()->put('included-code-theme', true);
        }

        return <<<HTML
        <style>$style</style>
        <pre><code class="hljs $highlighted->language">$highlighted->value</code></pre>
        HTML;
    }
}
