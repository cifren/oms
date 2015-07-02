var objectApp = angular.module('objectApp', [
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'controllers'
]);

objectApp
        .config(['$routeProvider',
            function ($routeProvider) {
                $routeProvider.
                        when('/list', {
                            name: 'list',
                            templateUrl: Routing.generate('api_common_templateaccess',
                                    {templateName: 'SuperAdminInterfaceBundle:Object:list.html.twig'}
                            ),
                            controller: 'List'
                        }).
                        when('/create', {
                            name: 'create',
                            templateUrl: Routing.generate('api_common_templateaccess',
                                    {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:edit.html.twig')}
                            ),
                            controller: 'Create'
                        }).
                        when('/edit/:id', {
                            name: 'edit',
                            templateUrl: Routing.generate('api_common_templateaccess',
                                    {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:edit.html.twig')}
                            ),
                            controller: 'Edit'
                        }).
                        otherwise({
                            redirectTo: '/list'
                        });
            }
        ])
        .factory("ctrlHelper", function () {
            return {
                addFieldType: [{value: "text", label: "Text"}, {value: "textarea", label: "Textarea"}],
                addNewField: function ($scope) {
                    var field = {
                        type: $scope.addField.new,
                    };
                    $scope.object.fields.push(field);
                },
                deleteRow: function (list, id) {
                    $.each(list, function (key, value) {
                        if (value.id == id) {
                            list.splice(key, 1);
                            //beak the loop
                            return false;
                        }
                    });
                },
                saveObject: function ($scope, $http, $location, controllerName) {
                    $scope.alert = {};
                    if ($scope.object.fields.length !== 0) {
                        $http
                                .post(Routing.generate('superadmin_api_object_save'), {formObject: $scope.object})
                                .success(function (data, status, headers, config) {
                                    if (data.status === 2) {//validation error
                                        $scope.alert.status = "danger";
                                        var aryMessage = [];
                                        $.each(data.validatorErrorList, function (keyGroupList, groupList) {
                                            $.each(groupList, function (key, value) {
                                                aryMessage.push("Group: " + value.class + " Field: " + value.propertyPath + " Message: " + value.message);
                                            });
                                        });
                                        var message = aryMessage.join('<br>');
                                        $scope.alert.message = message;
                                    } else if (data.status === 1) {//success
                                        $scope.alert.status = "success";
                                        $scope.alert.message = data.msg;

                                        $.each(data.data.fields, function (key, value) {
                                            $scope.object.fields[key].id = value.id;
                                        });
                                        if (controllerName === 'new') {
                                            $location.path('/edit/' + data.data.id);
                                        }
                                    } else {//unexpected
                                        $scope.alert.status = "danger";
                                        $scope.alert.message = "Error non-expected";
                                    }
                                })
                                .error(function (data, status, headers, config) {
                                    $scope.alert.status = "danger";
                                    $scope.alert.message = "Error non-expected";
                                });
                    } else {
                        $scope.alert.status = "danger";
                        $scope.alert.message = "You need to create at least one field";
                    }
                }
            }
        });
;