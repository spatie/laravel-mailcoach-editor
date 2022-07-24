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

        /** @var Upload $upload */
        $upload = Upload::create();
        
        if (isset($data['file'])) {
            $media = $upload
                ->addMediaFromRequest('file')
                ->toMediaCollection(
                    config('mailcoach-editor.collection_name', 'default'),
                    config('mailcoach-editor.disk_name'),
                );
        }

        if (isset($data['url'])) {
            $media = $upload
                ->addMediaFromUrl($data['url'])
                ->toMediaCollection(
                    config('mailcoach-editor.collection_name', 'default'),
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
