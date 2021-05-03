import 'vite/dynamic-import-polyfill';

import { $ } from './util';
import { showModal } from './components/modal';
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Quote from '@editorjs/quote';
import Delimiter from '@editorjs/delimiter';
import Raw from '@editorjs/raw';
import ImageTool from '@editorjs/image';
import Table from 'editorjs-table';
import InlineCode from '@editorjs/inline-code';
import Code from './tools/code';

document.addEventListener('turbolinks:load', initEditor);
document.addEventListener('load', initEditor);
document.addEventListener('before-visit', confirmBeforeLeaveAndDestroyEditor);
window.addEventListener('beforeunload', confirmBeforeLeaveAndDestroyEditor);

initEditor();

function confirmBeforeLeaveAndDestroyEditor(event) {
    if (! document.getElementById('html')) {
        return;
    }

    if (document.getElementById('html').dataset.dirty === "dirty" && ! confirm('Are you sure you want to leave this page? Any unsaved changes will be lost.')) {
        event.preventDefault();
        return;
    }

    document.removeEventListener('turbolinks:before-visit', confirmBeforeLeaveAndDestroyEditor);
    window.removeEventListener('beforeunload', confirmBeforeLeaveAndDestroyEditor);
    window.editor.destroy();
    window.editor = undefined;
}

async function jsonFetch(route, data) {
    const response = await fetch(route, {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
        headers: {
            'X-CSRF-Token': $('[name="_token"]').value,
        },
    })

    return response.json();
}

async function fetchHtml(route, data) {
    const response = await fetch(route, {
        method: 'POST',
        body: JSON.stringify({ data: data }),
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': $('[name="_token"]').value,
        },
    })

    const json = await response.json();

    return json.html;
}

function initEditor() {
    document.addEventListener('turbolinks:before-visit', confirmBeforeLeaveAndDestroyEditor);
    document.addEventListener("turbolinks:load", initEditor);
    window.addEventListener('beforeunload', confirmBeforeLeaveAndDestroyEditor);

    const node = $('#editor-js');
    if (! node || window.editor !== undefined) {
        return;
    }


    let data = node.dataset.structuredHtml ? JSON.parse(node.dataset.structuredHtml) : undefined;

    window.editor = new EditorJS({
        holder: node,
        autofocus: true,

        data: data,

        tools: {
            header: Header,
            list: List,
            image: {
                class: ImageTool,
                config: {
                    uploader: {
                        uploadByFile(file) {
                            const data = new FormData();
                            data.append('file', file);

                            return jsonFetch(node.dataset.upload, data);
                        },

                        uploadByUrl(url) {
                            const data = new FormData();
                            data.append('url', url);

                            return jsonFetch(node.dataset.upload, data);
                        }
                    }
                }
            },
            quote: Quote,
            delimiter: Delimiter,
            raw: Raw,
            table: {
                class: Table,
            },
            code: Code,
            inlineCode: {
                class: InlineCode,
                shortcut: 'CMD+SHIFT+M',
            },
        },

        onChange: () => {
            document.getElementById('html').dataset.dirty = "dirty";
        }
    });

    $('#save').addEventListener('click', (event) => {
        event.preventDefault();

        window.editor.save().then((outputData) => {
            fetchHtml(node.dataset.route, {
                body: outputData,
                template: $('#template').value,
            }).then(html => {
                document.getElementById('html').value = html;
                document.getElementById('body').value = JSON.stringify(outputData);
                document.getElementById('html').dataset.dirty = "";
                document.querySelector('main form').submit();
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        }).catch((error) => {
            console.log('Saving failed: ', error)
        });
    });

    $('#preview').addEventListener('click', (event) => {
        event.preventDefault();
        window.editor.save().then((outputData) => {
            fetchHtml(node.dataset.route, {
                body: outputData,
                template: $('#template').value,
            }).then(html => {
                $('#html').value = html;
                const input = document.createEvent('Event');
                input.initEvent('input', true, true);
                document.getElementById('html').dispatchEvent(input);
                showModal('preview');
            });
        });
    });

    $("[data-modal-trigger=\"edit-template\"]").addEventListener('click', (e) => {
        document.getElementById("structured_html[template]").value = $('#template').value;
    });

    $("[data-modal-confirm=\"edit-template\"]").addEventListener('click', (e) => {
        $('#template').value = document.getElementById("structured_html[template]").value;
    });
}
