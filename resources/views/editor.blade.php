<div class="form-grid">
    <style>
        .btn.btn--default {
            color: #fff;
        }

        .btn.btn--default:hover {
            color: #fff;
            background: #0a59da;
        }
    </style>
    <script>
        function upload(data) {
            return fetch('{{ action(\Spatie\Mailcoach\Http\Api\Controllers\UploadsController::class) }}', {
                method: 'POST',
                body: data,
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }).then(response => response.json());
        }

        window.init = function() {
            const editor = new EditorJS({
                holder: this.$refs.editor,
                data: this.json,
                autofocus: true,
                placeholder: '{{ __('Write something awesome!') }}',
                logLevel: 'ERROR',
                tools: {
                    header: {
                        class: Header,
                        config: {
                            levels: [1, 2, 3],
                        }
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                    },
                    image: {
                        class: ImageTool,
                        config: {
                            uploader: {
                                uploadByFile(file) {
                                    const data = new FormData();
                                    data.append('file', file);

                                    return upload(data);
                                },

                                uploadByUrl(url) {
                                    const data = new FormData();
                                    data.append('url', url);

                                    return upload(data);
                                }
                            }
                        }
                    },
                    quote: Quote,
                    delimiter: Delimiter,
                    raw: RawTool,
                    table: {
                        class: Table,
                    },
                    code: CodeTool,
                    button: AnyButton,
                    inlineCode: {
                        class: InlineCode,
                        shortcut: 'CMD+SHIFT+M',
                    },
                },

                onChange: () => {
                    const self = this;
                    this.$refs.editor.dirty = true;
                    editor.save().then((outputData) => {
                        self.json = outputData;

                        fetch('{{ action(\Spatie\MailcoachEditor\Http\Controllers\RenderEditorController::class) }}', {
                            method: 'POST',
                            body: JSON.stringify(outputData),
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            }
                        })
                        .then(response => response.json())
                        .then(({ html }) => this.html = html);
                    });
                }
            });
        }
    </script>

    @if ($model->hasTemplates())
        <x-mailcoach::template-chooser :clearable="false" />
    @endif

    @foreach($template?->fields() ?? [['name' => 'html', 'type' => 'editor']] as $field)
        <x-mailcoach::editor-fields :name="$field['name']" :type="$field['type']" :label="$field['name'] === 'html' ? 'Content' : null">
            <x-slot name="editor">
                <div class="markup markup-lists markup-links markup-code pr-16 max-w-[750px]">
                    <div class="px-6 py-4 input bg-white" wire:ignore x-data="{
                        html: @entangle('templateFieldValues.' . $field['name'] . '.html'),
                        json: @entangle('templateFieldValues.' . $field['name'] . '.json'),
                        init: init,
                    }">
                        <div x-ref="editor" data-dirty-check></div>
                    </div>
                </div>
            </x-slot>
        </x-mailcoach::editor-fields>
    @endforeach

    <x-mailcoach::replacer-help-texts :model="$model" />

    <x-mailcoach::editor-buttons :preview-html="$fullHtml" :model="$model" />
</div>
