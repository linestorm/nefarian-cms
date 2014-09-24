'use strict';

var ctrlr = '/app_dev.php';
define(['jquery', 'jqueryui', 'angular', 'bootstrap', 'cms/core/api'], function ($, ui, ang, bs, api) {

    var viewsApp = angular.module('viewsApp', []);

    var storage = (function () {
        var prefix = 'nefarian.views.';
        return {
            'set': function (key, data) {
                window.localStorage.setItem(prefix + key, JSON.stringify(data));
            },
            'get': function (key) {
                var obj = window.localStorage.getItem(prefix + key);
                if (obj) {
                    try {
                        return JSON.parse(obj);
                    }
                    catch (e) {
                        return null;
                    }
                } else {
                    return null;
                }
            }
        }
    })();

    viewsApp.controller('ViewsCtrl', ['$scope', '$http', function ($scope, $http) {

        $scope.entities = {};
        $scope.fields = [];
        $scope.associations = [];
        $scope.settings = {
            name: '',
            description: '',
            entity: null,
            fields: [],
            associations: []
        };

        $scope.onEntitySelect = function (hash) {
            $http.get(ctrlr + '/api/view/entity/fields.json', {
                params: {
                    entity: hash
                },
                cache: true
            }).success(function (data) {
                $scope.fields = [];
                for (var i = 0; i < data.fields.length; ++i) {
                    $scope.fields.push({
                        name: data.fields[i],
                        class: hash,
                        selected: true
                    });
                    storage.set('fields', $scope.fields);
                }
                $scope.associations = [];
                for (var i = 0; i < data.associations.length; ++i) {
                    $scope.associations.push({
                        name: data.associations[i].name,
                        hash: data.associations[i].hash,
                        selected: false
                    });
                    storage.set('associations', $scope.associations);
                }
            });
            storage.set('settings', $scope.settings);
        };

        $scope.toggleAssociation = function (association) {
            if (association.selected) {
                $http.get(ctrlr + '/api/view/entity/fields.json', {
                    params: {
                        entity: association.hash
                    },
                    cache: true
                }).success(function (data) {
                    for (var i = 0; i < data.fields.length; ++i) {
                        $scope.fields.push({
                            name: data.fields[i],
                            class: association.hash,
                            selected: false
                        });
                        storage.set('fields', $scope.fields);
                    }
                });
            } else {
                for (var i = 0; i < $scope.fields.length; ++i) {
                    if ($scope.fields[i].class == association.hash) {
                        $scope.fields.splice(i, 1);
                    }
                }
            }
            storage.set('settings', $scope.settings);
        };

        $scope.toggleField = function (field) {
            $scope.settings.fields = [];
            var new_val = $scope.fields;
            for (var i = 0; i < new_val.length; ++i) {
                if (new_val[i].selected) {
                    $scope.settings.fields.push(new_val[i].name);
                }
            }
            storage.set('settings', $scope.settings);
        };

        // check local storage
        var stored = {
            settings: storage.get('settings'),
            entities: storage.get('entities'),
            fields: storage.get('fields'),
            associations: storage.get('associations')
        }

        if (stored.settings) {
            $scope.settings = stored.settings;
        }
        if (stored.entities) {
            $scope.entities = stored.entities;
        } else {
            $http.get(ctrlr + '/api/view/entities.json').success(function (data) {
                $scope.entities = data;
                storage.set('entities', data);
            });
        }
        if(stored.fields){
            $scope.fields = stored.fields;
        } else if($scope.settings.entity){
            $scope.onEntitySelect($scope.settings.entity);
        }
        if(stored.associations){
            $scope.associations = stored.associations;
        } else if($scope.settings.entity){
            $scope.onEntitySelect($scope.settings.entity);
        }
    }]);

    angular.bootstrap(document, ['viewsApp']);
});
