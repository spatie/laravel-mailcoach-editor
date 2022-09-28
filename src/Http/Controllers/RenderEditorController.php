<?php

namespace Spatie\MailcoachEditor\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MailcoachEditor\Editor;

class RenderEditorController
{
    public function __invoke(Request $request)
    {
        $data = $request->all();

        $html = Editor::renderBlocks($data['blocks']);

        return response()->json(['html' => $html]);
    }
}
