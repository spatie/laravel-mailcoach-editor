<style>
    /* Disable some default Editor.js styles that conflict with TailwindCSS */
    .cdx-list--unordered,
    .cdx-list--ordered {
        list-style: none;
    }

    .cdx-list {
        padding-left: 0;
    }

    .ce-header {
        padding: 0;
    }

    .ce-block__content .table-row {
        display: flex !important;
        flex-direction: row !important;
    }

    .prose table {
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<div class="prose border rounded-md bg-gray-100 px-8 py-8 min-w-full" style="min-height: 350px;">
    <div class="bg-white shadow-md min-h-full py-6 rounded-md">
        <div id="editor-js"
             data-structured-html="{{ $structured_html }}"
             data-route="{{ action([\Spatie\MailcoachEditor\Http\Controllers\EditorController::class, 'render']) }}"
             data-upload="{{ action([\Spatie\MailcoachEditor\Http\Controllers\EditorController::class, 'upload']) }}"
        ></div>
    </div>
</div>

<input type="hidden" id="structured_html" name="structured_html[body]" value="{{ old('structured_html.body', $structured_html) }}">
<input type="hidden" id="html" name="html" value="{{ old('html', $html) }}" data-html-preview-source>
<div class="form-buttons">
    <x-mailcoach::button id="save" :label="__('Save content')"/>
    <x-mailcoach::button-secondary id="preview" :label="__('Preview')"/>
    <x-mailcoach::button-secondary data-modal-trigger="send-test" :label="__('Send Test')"/>
</div>
