
define(['jquery', 'summernote'], function ( $, summernote) {

    // add ckeditor to all the pre-loaded articles
    $('textarea.wysiwyg-editor').summernote({
        focus: true,
        height: 400,
        minHeight: 400
    });

});
