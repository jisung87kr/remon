<form action="{{ $route }}" class="mt-6" method="POST">
    @csrf
    @method($method)
    <div class="flex gap-1 flex-wrap">
        @if(false)
        <button type="button" class="button button-gray-outline shrink-0">카테고리1</button>
        <button type="button" class="button button-gray-outline shrink-0">카테고리2</button>
        <button type="button" class="button button-gray-outline shrink-0">카테고리1</button>
        @endif
    </div>
    <div class="mt-3">
        <div class="mb-3">
            <select name="status" id="status" class="form-select">
                @foreach(\App\Enums\PostStatusEnum::cases() as $case)
                    <option value="{{ $case->value }}" @selected($case == $post->status)>{{ $case->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
            <x-input-error for="title"></x-input-error>
        </div>
        <div>
            <textarea name="content" id="editor" cols="30" rows="10" class="form-control mt-3" style="height: 300px">{{ old('content', $post->content) }}</textarea>
            <x-input-error for="content"></x-input-error>
        </div>
        <div class="text-center mt-6">
            <a href="" class="button button-gray-outline">취소</a>
            <input type="submit" class="button button-gray" value="등록">
        </div>
    </div>
</form>
<style>
    .ck-editor__editable {
        min-height: 400px; /* 원하는 높이로 지정 */
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
<script>
  CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
    ckfinder: {
      uploadUrl: '{{ route('board.upload') }}'
    },
    toolbar: {
      items: [
        'exportPDF','exportWord', '|',
        'findAndReplace', 'selectAll', '|',
        'heading', '|',
        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
        'bulletedList', 'numberedList', 'todoList', '|',
        'outdent', 'indent', '|',
        'undo', 'redo',
        '-',
        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
        'alignment', '|',
        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
        'textPartLanguage', '|',
        'sourceEditing'
      ],
      shouldNotGroupWhenFull: true
    },
    removePlugins: [
      // These two are commercial, but you can try them out without registering to a trial.
      // 'ExportPdf',
      // 'ExportWord',
      'AIAssistant',
      'CKBox',
      'CKFinder',
      'EasyImage',
      // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
      // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
      // Storing images as Base64 is usually a very bad idea.
      // Replace it on production website with other solutions:
      // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
      // 'Base64UploadAdapter',
      'MultiLevelList',
      'RealTimeCollaborativeComments',
      'RealTimeCollaborativeTrackChanges',
      'RealTimeCollaborativeRevisionHistory',
      'PresenceList',
      'Comments',
      'TrackChanges',
      'TrackChangesData',
      'RevisionHistory',
      'Pagination',
      'WProofreader',
      // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
      // from a local file system (file://) - load this site via HTTP server if you enable MathType.
      'MathType',
      // The following features are part of the Productivity Pack and require additional license.
      'SlashCommand',
      'Template',
      'DocumentOutline',
      'FormatPainter',
      'TableOfContents',
      'PasteFromOfficeEnhanced',
      'CaseChange'
    ]
  });
</script>
