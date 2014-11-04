define(['jquery', 'jqueryui', 'bootstrap', 'select2', 'cms/content_management/editor/editor', 'cms/content_management/node/form'], function ($, ui, bs, s2, editor, nodeForm) {
    nodeForm.registerWidget('body', function($scope){
        editor.bindEditor('ckeditor', $scope);
    });
});
