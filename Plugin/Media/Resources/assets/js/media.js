
define(['jquery', 'jqueryui', 'bootstrap', 'dropzone', 'typeahead', 'cms_api', 'cms_media_dropzone', 'cms_media_treebrowser'], function ($, jui, bs, Dropzone, typeahead, api, mDz, mTree) {

    // setup dropzone
    Dropzone.autoDiscover = false;

    var $form;
    var $dropzone;
    var carrosselDropZone;

    $(document).ready(function(){
        $form = $('form[name="linestorm_cms_form_media"],form[name="linestorm_cms_form_media_category"]');
        $dropzone = $('.dropzone');

        var formCount = parseInt($form.data('count')) || 0;

        var $tree = $('.media-browser');
        var tree = mTree.mediaTree($tree);

        if($dropzone.length){
            var dz = mDz.dropzone($dropzone, {
                max: 0
            });

            dz.on('success', function(file, response) {
                if($form.data('category-id')){
                    $form.find('.media-form-category').val($form.data('category-id'));
                } else {
                    var selected = tree.tree.jstree('get_selected',true);
                    if(selected.length){
                        $form.find('.media-form-category').val(selected[0].original.node.id);
                    }
                }
            });
        }


        $('form[name="linestorm_cms_form_media_multiple"]').on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            var $form = $(this),
                $mediaItems = $form.find('.media-tile');
            api.saveForm($form, function(on, status, xhr){
                $mediaItems.remove();
            }, function(e, status, ex){
                if(e.status === 400){
                    if(e.responseJSON){
                    } else {
                        alert(status);
                    }
                }
            });

            return false;
        });

        $('form.media-api-save').on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            api.saveForm($(this), function(on, status, xhr){
                if(xhr.status === 200){
                } else if(xhr.status === 201) {
                } else {
                }
            }, function(e, status, ex){
                if(e.status === 400){
                    if(e.responseJSON){
                    } else {
                        alert(status);
                    }
                }
            });

            return false;
        });

        $('.media-form-delete').on('click', function(){
            if(confirm("Are you sure you want to permanently delete this media?\n\nWARNING: IF IT IS USED ANYWHERE, IT WILL CREATE 404 RESPONSES")){
                api.call($(this).data('url'), {
                    type: 'DELETE',
                    success: function(o){
                        alert(o.message);
                        window.location = o.location;
                    }
                });
            }
        });

        $('.media-form-child-delete').on('click', function(){
            var $mediaChildRow = $(this).closest('tr.media-child-row');
            if(confirm("Are you sure you want to permanently delete this media?\n\nWARNING: IF IT IS USED ANYWHERE, IT WILL CREATE 404 RESPONSES")){
                api.call($(this).data('url'), {
                    type: 'DELETE',
                    success: function(o){
                        $mediaChildRow.remove();
                    }
                });
            }
        });

        $('.media-children-regenerate').on('click', function(){
            var $mediaChildRow = $(this).closest('tr.media-child-row');
            if(confirm("Are you sure you want to regenerate all resized media?")){
                api.call($(this).data('url'), {
                    type: 'PATCH',
                    success: function(o){
                        window.location.reload();
                    }
                });
            }
        });

    });

});
