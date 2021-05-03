<?php

namespace Spatie\MailcoachEditor\Renderer;

use Spatie\MailcoachEditor\Renderer;

class TableRenderer extends Renderer
{
    public function render(): string
    {
        $table = "<table>";

        foreach ($this->data['content'] as $row => $columns) {
            $table .= "<tr>";
            foreach ($columns as $column) {
                $table .= "<td>{$column}</td>";
            }
            $table .= "</tr>";
        }

        $table .= "</table>";

        return <<<HTML
        $table
        HTML;
    }
}
