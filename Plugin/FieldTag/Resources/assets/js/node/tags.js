define(['jquery', 'jqueryui', 'bootstrap', 'select2', 'cms/content_management/node/form'], function ($, ui, bs, s2, nodeForm) {

    nodeForm.registerWidget('tag', function($scope){
        $scope.find('input.content-tags').each(function(){
            var $input = $(this);
            $input.wrap('<div class="select2-primary"></div>').select2({
                placeholder: "Select tags",
                tags: $input.data('options').split(','),
                tokenSeparators: [","]
            });
        });
    });

});
