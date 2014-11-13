
define(['jquery', 'bootstrap', 'cms_api', 'cms_file_treebrowser'], function ($, bs, api, mTree) {
    $(document).ready(function(){

        var $tree = $('.file-browser');
        mTree.fileTree($tree);

        $('.file-edit').on('click', function(){
            var selected = $('.file-tree').jstree('get_selected', true);
            for(var i=0 ; i<selected.length ; ++i){
                var item = selected[i];
                switch(item.type){
                    case "default":
                    case "file":
                        window.location = item.original.node.url;
                        break;
                }
            }
        });
    });
});
