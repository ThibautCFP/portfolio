import ClassicEditorBase from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials';
import AutoformatPlugin from '@ckeditor/ckeditor5-autoformat/src/autoformat';
import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold';
import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic';
import BlockQuotePlugin from '@ckeditor/ckeditor5-block-quote/src/blockquote';
import HeadingPlugin from '@ckeditor/ckeditor5-heading/src/heading';
import LinkPlugin from '@ckeditor/ckeditor5-link/src/link';
import ListPlugin from '@ckeditor/ckeditor5-list/src/list';
import ParagraphPlugin from '@ckeditor/ckeditor5-paragraph/src/paragraph';


const form = document.querySelector('.form-project');

if (form) {
    const ckeditorInput = form.querySelector('#ckeditor');
    const placeholder = ckeditorInput.dataset.placeholder;

    ClassicEditorBase
        .create(
            ckeditorInput,
            {
                plugins: [
                    EssentialsPlugin, AutoformatPlugin, BoldPlugin, ItalicPlugin, BlockQuotePlugin, HeadingPlugin, LinkPlugin,
                    ListPlugin, ParagraphPlugin,
                ],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'link', '|',
                        'undo',
                        'redo',
                    ]
                },
                placeholder: placeholder,
            })
        .then(editor => {
            window.editor = editor;

            window.preventPasteFromOfficeNotification = true;

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const editorData = editor.data.get();
                const inputHidden = form.querySelector('.js-ckedit-input-hidden');
                inputHidden.value = editorData;
                form.submit();
            })
        })
        .catch(error => {
            console.error(error);
        });
}