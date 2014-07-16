define(['jquery', 'bootstrap', 'cms/core/api'], function ($, bs, api) {
   $(document).ready(function(){
       $('form').on('submit', function(){
            api.saveForm($(this));
       });
   });
});
