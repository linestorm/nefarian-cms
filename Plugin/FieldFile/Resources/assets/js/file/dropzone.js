define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'dropzone', 'cms/core/api'], function ($, ui, bs, bootbox, dz, api) {

    $(document).ready(function () {

        var $dropzones = $('div.dropzone-box');
        $dropzones.each(function () {
            var $dropzone = $(this);
            var prototype = $dropzone.data('prototype');
            var formCount = 0;
            var formItems = $dropzone.data('items');
            var mimeTypes = $dropzone.data('mime-types');
            var limit = parseInt($dropzone.data('limit'));
            $dropzone.dropzone({
                url: $dropzone.data('url'),
                maxFiles: limit ? limit : null,
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 5, // MB
                acceptedFiles: mimeTypes,

                addRemoveLinks: true,
                dictResponseError: "Can't upload file!",
                autoProcessQueue: true,
                thumbnailWidth: 238,
                thumbnailHeight: 160,

                previewTemplate: prototype,
                // previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size">File size: <span data-dz-size></span></div><div class="dz-thumbnail-wrapper"><div class="dz-thumbnail"><img data-dz-thumbnail><span class="dz-nopreview">No preview</span><div class="dz-success-mark"><i class="fa fa-check-circle-o"></i></div><div class="dz-error-mark"><i class="fa fa-times-circle-o"></i></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div></div></div><div class="progress progress-striped active"><div class="progress-bar progress-bar-success" data-dz-uploadprogress></div></div></div>',
                resize: function (file) {
                    var info = {srcX: 0, srcY: 0, srcWidth: file.width, srcHeight: file.height},
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

                init: function () {
                    this.on("success", function (file, response) {
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
                    this.on("error", function (file, response) {
                        this.removeFile(file);
                        var errorMsg = response.error ? "Cannot add file:" + response.error : response;
                        bootbox.alert({
                            message: errorMsg,
                            className: "bootbox-md"
                        });
                    });

                    var tDz = this;

                    for (var i = 0; i < formItems.length; ++i) {
                        var item = formItems[i];
                        var mockFile = {
                            name: item.filename,
                            size: item.size,
                            type: 'preload',
                            accepted: true
                        };

                        tDz.options.addedfile.call(tDz, mockFile);
                        tDz.options.thumbnail.call(tDz, mockFile, item.url);
                        tDz.emit.call(tDz, "success", mockFile, [item]);
                        tDz.files.push(mockFile);
                        tDz.accept.call(tDz, mockFile, function (a) {
                        });
                        tDz._updateMaxFilesReachedClass()
                    }

                }
            });

            // set up the sortable content
            $dropzone.sortable({
                items: '> .dz-preview',
                create: function (event, ui) {
                },
                start: function (e, ui) {

                },
                stop: function (e, ui) {
                    $dropzone.children('.dz-preview').each(function (i, el) {
                        var $container = $(el);
                        var elements = ['filename', 'size', 'status', 'path', 'url', 'title', 'description'];

                        for (var j = 0; j < elements.length; ++j) {
                            var $item = $container.find('[name*="[' + elements[j] + ']"]');
                            $item.attr('name', $item.data('field-name').replace(/__delta__/g, i));
                        }
                    });
                }
            });
        });
    });
});
