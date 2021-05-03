<?php

namespace Spatie\MailcoachEditor\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MailcoachEditor\Editor;
use Spatie\MailcoachEditor\Models\Upload;

class EditorController
{
    public function render(Request $request)
    {
        $data = $request->get('data');

        $html = Editor::renderBlocks($data['body']['blocks'], $data['template']);

        return response()->json(['html' => $html]);
    }

    public function upload(Request $request)
    {
        $data = $request->validate([
            'file' => ['nullable', 'required_without:url', 'image'],
            'url' => ['nullable', 'url', 'required_without:file'],
        ]);

        if (isset($data['file'])) {
            $upload = Upload::create();
            $media = $upload
                ->addMediaFromRequest('file')
                ->toMediaCollection(
                    'default',
                    config('mailcoach-editor.disk_name'),
                );
        }

        if (isset($data['url'])) {
            /** @var Upload $upload */
            $upload = Upload::create();
            $media = $upload
                ->addMediaFromUrl($data['url'])
                ->toMediaCollection(
                    'default',
                    config('mailcoach-editor.disk_name'),
                );
        }

        if (! isset($media)) {
            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $media->getFullUrl('image'),
            ],
        ]);
    }
}
