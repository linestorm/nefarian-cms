define(['jquery'], function ($) {

    var editors = {};

    var editorManager = {
        registerEditor: function (name, callback) {
            editors[name] = callback;
            callback($(document));
        },
        bindEditor: function (name, $editor) {
            var callback = editors[name];
            if(callback) {
                callback($editor);
            }
        }
    };

    return editorManager;
});
