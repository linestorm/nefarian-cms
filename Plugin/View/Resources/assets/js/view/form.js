'use strict';

var ctrlr = '/app_dev.php';
define(['jquery', 'jqueryui', 'angular', 'bootstrap', 'cms/core/api'], function ($, ui, ang, bs, api) {

    var viewsApp = angular.module('viewsApp', []);

    viewsApp.controller('ViewsCtrl', ['$scope', '$http', function ($scope, $http) {

        $scope.entities = {};
        $scope.fields = [];
        $scope.settings = {
            name: '',
            description: '',
            entity: null,
            fields: []
        };

        $scope.onEntitySelect = function () {
            $http.get(ctrlr + '/api/view/entity/fields.json', {
                params: {
                    entity: $scope.settings.entity
                }
            }).success(function (data) {
                $scope.fields = [];
                for(var i=0 ; i<data.length ; ++i){
                    $scope.fields.push({
                        field: data[i],
                        selected: false
                    });
                }
            });
        };

        $scope.toggleField = function (field) {
            var idx = $scope.settings.fields.indexOf(field);
            if (idx > -1) {
                $scope.settings.fields.splice(idx, 1);
            } else {
                $scope.settings.fields.push(field);
            }
        };

        $scope.$watch($scope.fields, function(old_val, new_val){
            if(new_val === old_val){
                return;
            }
            console.log(new_val);
        });

        $http.get(ctrlr + '/api/view/entities.json').success(function (data) {
            $scope.entities = data;
        });

    }]);

    angular.bootstrap(document, ['viewsApp']);
    /*
     $(document).ready(function () {

     var $form = $('form.api-save');

     $form.on('submit', function (e) {
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

     var $fieldContainer = $('ul.field-selection');
     var fieldCount = $fieldContainer.children().length;
     $form.on('click', '.field-add', function(){
     $.ajax({
     url: $(this).data('url'),
     dataType: 'json',
     data: {
     entity: $('#nefarian_plugin_view_new_base_entity').val()
     },
     success: function(ob){
     console.log(ob);
     }
     });
     });
     $fieldContainer.on('click', '.field-remove', function(){
     $(this).closest('li').remove();
     fieldCount--;
     });

     $form.on('click', '.api-delete', function(){
     var a = this;
     bootbox.dialog({
     title: 'Delete node',
     message: 'Are you sure you want to remove this node?',
     buttons: {
     cancel: {
     label: 'Cancel'
     },
     delete: {
     label: "Delete Node",
     className: "btn-danger",
     callback: function() {
     api.call(a.href, {
     method: 'DELETE',
     success:function(o){
     bootbox.alert('The node has been removed.', function(){

     });
     }
     });
     }
     }
     }
     });

     return false;
     });
     });*/
});
