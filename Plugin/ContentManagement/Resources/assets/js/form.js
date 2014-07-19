define(['jquery', 'jqueryui', 'bootstrap', 'cms/core/api'], function ($, ui, bs, api) {

    $(document).ready(function () {
        $('form').on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this), function (ob, status, xhr) {
                var location = xhr.getResponseHeader('location');
                if (location && location.length) {
                    window.location = location;
                }
            });
            return false;
        });

        var $addTypeFieldButton = $('.field-type-add'),
            $typeFieldTable     = $('table.field-type > tbody'),
            typeFieldCount      = $typeFieldTable.children().length;

        $addTypeFieldButton.on('click', function (e) {
            var template = $addTypeFieldButton.data('prototype');
            template = template.replace(/__name__/g, typeFieldCount);
            ++typeFieldCount;

            var $template = $(template);
            $template.find('input[name*="[order]"]').val(typeFieldCount);

            $typeFieldTable.append($template);
            $typeFieldTable.sortable('refresh');
        });

        $typeFieldTable.on('click', '.field-type-remove', function(){
            if(confirm('Are you sure you want to remove this field?')){
                $(this).closest('tr').remove();
                $typeFieldTable.sortable('refresh');
            }
        });

        $typeFieldTable.sortable({
            items: '> tr',
            axis: 'y',
            create: function( event, ui ) {
                var $ul = $(this);
                $ul.children('tr').sort(function(a,b) {
                    var keyA = parseInt(a.dataset.order);
                    var keyB = parseInt(b.dataset.order);
                    if (keyA < keyB) return -1;
                    if (keyA > keyB) return 1;
                    return 0;
                }).appendTo($ul);
            },
            stop:function(e,ui){

                // update the order
                $typeFieldTable.children('tr').each(function(i, tr){
                    var $tr = $(tr);
                    $tr.find('input[name*="[order]"]').val(i);
                });
            }
        });

    });
});
