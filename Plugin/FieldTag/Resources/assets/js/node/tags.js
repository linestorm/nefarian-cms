define(['jquery', 'jqueryui', 'bootstrap', 'select2'], function ($, ui, bs, s2) {

    $('input.content-tags').each(function(){
        var $input = $(this);
        $input.wrap('<div class="select2-primary"></div>').select2({
            placeholder: "Select tags",
            tags: $input.data('options').split(','),
            tokenSeparators: [","]
        });
    });
});
