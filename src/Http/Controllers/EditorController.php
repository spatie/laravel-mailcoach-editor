<?php

namespace Spatie\MailcoachEditor\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MailcoachEditor\Models\Upload;
use Spatie\MailcoachEditor\BlockRendererFactory;

class EditorController
{
    public function render(Request $request)
    {
        $data = $request->get('data');

        $html = "";
        foreach ($data['blocks'] as $block) {
            $renderer = BlockRendererFactory::create($block['type'], $block['data']);
            $html .= $renderer->render();
            $html .= "\n";
        }

        $html = view('mailcoach-editor::template', [
            'content' => $html,
        ])->render();

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
                    config('mailcoach.editor.disk_name', config('medialibrary.disk_name', 'public')),
                );
        }

        if (isset($data['url'])) {
            /** @var Upload $upload */
            $upload = Upload::create();
            $media = $upload
                ->addMediaFromUrl($data['url'])
                ->toMediaCollection(
                    'default',
                    config('mailcoach.editor.disk_name', config('medialibrary.disk_name', 'public')),
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
