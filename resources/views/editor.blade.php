@push('modals')
    @php
        try {
            $manifest = json_decode(file_get_contents(public_path('vendor/mailcoach-editor/manifest.json')), true);
        } catch (Exception $e) {
            $manifest = null;
        }
    @endphp
    @if ($manifest)
        <script type="module" src="/vendor/mailcoach-editor/{{ $manifest['resources/js/editor.js']['file'] }}"></script>
    @else
        <script type="module" src="http://localhost:3000/@vite/client"></script>
        <script type="module" src="http://localhost:3000/resources/js/editor.js"></script>
    @endif
@endpush
<style>
    #editor-js h1 {
        font-weight: 800;
        font-size: 36px;
        margin-bottom: 32px;
        line-height: 40px;
    }

    #editor-js h2 {
        font-size: 24px;
        font-weight: 700;
        margin-top: 48px;
        margin-bottom: 24px;
        line-height: 32px;
    }

    #editor-js h3 {
        font-size: 20px;
        font-weight: 600;
        margin-top: 32px;
        margin-bottom: 12px;
        line-height: 32px;
    }

    #editor-js h4 {
        font-weight: 600;
        margin-top: 24px;
        margin-bottom: 8px;
        line-height: 24px;
    }

    .cdx-input {
        padding: 5px 10px;
        font-size: 15px;
    }

    .ce-block__content .table-row {
        display: flex !important;
        flex-direction: row !important;
    }
</style>
<div class="prose border rounded-md bg-gray-100 px-8 py-8" style="max-width: 50rem; padding-top: 2rem; padding-bottom: 2rem;">
    <div class="bg-white shadow-md min-h-full py-6 rounded-md">
        <div id="editor-js"
             data-structured-html="{{ $body ?? '' }}"
             data-route="{{ action([\Spatie\MailcoachEditor\Http\Controllers\EditorController::class, 'render']) }}"
             data-upload="{{ action([\Spatie\MailcoachEditor\Http\Controllers\EditorController::class, 'upload']) }}"
        ></div>
        @error('html')
            <p class="form-error" role="alert">{{ $message }}</p>
        @enderror
    </div>
</div>

<input type="hidden" id="body" name="structured_html[body]" value="{{ old('structured_html.body', $body ?? '') }}">
<input type="hidden" id="template" name="structured_html[template]" value="{{ old('structured_html.template', $template ?? '') }}">
<input type="hidden" id="html" name="html" value="{{ old('html', $html) }}" data-html-preview-source>
<div class="form-buttons">
    <x-mailcoach::button id="save" :label="__('Save content')"/>
    <x-mailcoach::button-secondary data-modal-trigger="edit-template" :label="__('Edit template')"/>
    <x-mailcoach::button-secondary id="preview" :label="__('Preview')"/>
    <x-mailcoach::button-secondary data-modal-trigger="send-test" :label="__('Send Test')"/>
</div>

@push('modals')
    <x-mailcoach::modal :title="__('Edit template')" name="edit-template" large>
        <div class="p-6">
            <p class="mb-6">{!! __('Make sure to include a <code>::content::</code> placeholder where the Editor‘s content should go.') !!}</p>

            <x-mailcoach::html-field name="structured_html[template]" :value="old('structured_html.template', $template ?? '')" />

            <div class="form-buttons">
                <x-mailcoach::button data-modal-confirm="edit-template" type="button" :label=" __('Save')" />
            </div>
        </div>
    </x-mailcoach::modal>
@endpush
