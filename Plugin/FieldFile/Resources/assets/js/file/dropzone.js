define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'dropzone', 'cms/core/api'], function ($, ui, bs, bootbox, dz, api) {

    $(document).ready(function () {

        var $dropzone = $('div.dropzone-box');
        var prototype = $dropzone.data('prototype');
        var formCount = $dropzone.data('count');
        $dropzone.dropzone({
            url: $dropzone.data('url'),
            maxFiles: $dropzone.data('limit'),
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 5, // MB

            addRemoveLinks : true,
            dictResponseError: "Can't upload file!",
            autoProcessQueue: true,
            thumbnailWidth: 138,
            thumbnailHeight: 120,

            previewTemplate:  prototype,
// '<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size">File size: <span data-dz-size></span></div><div class="dz-thumbnail-wrapper"><div class="dz-thumbnail"><img data-dz-thumbnail><span class="dz-nopreview">No preview</span><div class="dz-success-mark"><i class="fa fa-check-circle-o"></i></div><div class="dz-error-mark"><i class="fa fa-times-circle-o"></i></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div></div></div><div class="progress progress-striped active"><div class="progress-bar progress-bar-success" data-dz-uploadprogress></div></div></div>',
            resize: function(file) {
                var info = { srcX: 0, srcY: 0, srcWidth: file.width, srcHeight: file.height },
                    srcRatio = file.width / file.height;
                if (file.height > this.options.thumbnailHeight || file.width > this.options.thumbnailWidth) {
                    info.trgHeight = this.options.thumbnailHeight;
                    info.trgWidth = info.trgHeight * srcRatio;
                    if (info.trgWidth > this.options.thumbnailWidth) {
                        info.trgWidth = this.options.thumbnailWidth;
                        info.trgHeight = info.trgWidth / srcRatio;
                    }
                } else {
                    info.trgHeight = file.height;
                    info.trgWidth = file.width;
                }
                return info;
            },

            init: function(){
                this.on("success", function(file, response) {
                    var $form = $(file.previewElement);

                    var $container = $form.find('.file-form-container');
                    $container.html($container.html().replace(/__name__/g, formCount));
                    ++formCount;

                    $container.find('input[name*="[filename]"]').val(response[0].filename);
                    $container.find('input[name*="[size]"]').val(response[0].size);
                    $container.find('input[name*="[status]"]').val(response[0].status);
                    $container.find('input[name*="[path]"]').val(response[0].path);
                    $container.find('input[name*="[url]"]').val(response[0].url);
                    $container.find('input[name*="[title]"]').val(response[0].title);
                    $container.find('textarea[name*="[description]"]').val(response[0].description);

                });
                this.on("error", function(file, response) {
                    this.removeFile(file);
                    alert("Cannot add file: "+response);
                });
            }
        });
    });
});
