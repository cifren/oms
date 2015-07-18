var controllers = angular.module('controllers', []);

controllers.controller('List', ['$scope', '$location', '$http', 'ctrlHelper',
    function List($scope, $location, $http, ctrlHelper) {
        $http
                .get(Routing.generate('api_remotedataaccess_getrepositoryjson',
                        {
                            entityName: 'SuperAdmin-CoreBundle-Entity-Object',
                            functionName: 'findAll'
                        }
                ))
                .success(function (data, status, headers, config) {
                    $scope.objects = data;
                });
        $scope.deleteObject = function (id) {
            $http
                    .post(Routing.generate('superadmin_api_object_delete'), {id: id})
                    .success(function (data, status, headers, config) {
                        ctrlHelper.deleteRow($scope.objects, id);
                        $scope.alert.status = "success";
                        $scope.alert.message = "Object deleted";
                    })
                    .error(function (data, status, headers, config) {
                        $scope.alert.status = "danger";
                        $scope.alert.message = "Error non-expected";
                    });
        };
        $scope.generateObject = function (id) {
            $http
                    .post(Routing.generate('superadmin_api_object_generate'), {id: id})
                    .success(function (data, status, headers, config) {
                        $scope.alert.status = "success";
                        $scope.alert.message = data.message;
                    })
                    .error(function (data, status, headers, config) {
                        $scope.alert.status = "danger";
                        $scope.alert.message = "Error non-expected";
                    });
        };
    }
]);
controllers.controller('Edit', ['$scope', '$http', 'ctrlHelper', '$routeParams',
    function Edit($scope, $http, ctrlHelper, $routeParams) {
        $http
                .get(Routing.generate('api_remotedataaccess_getrepositoryjson',
                        {
                            entityName: 'SuperAdmin-CoreBundle-Entity-Object',
                            functionName: 'find',
                            parameters: [$routeParams.id]
                        }
                ))
                .success(function (data, status, headers, config) {
                    if ($scope.object === undefined) {
                        $scope.object = {};
                    }
                    $scope.object.id = data.id;
                    $scope.object.name = data.name;
                    $scope.object.description = data.description;
                })
                .error(function (data, status, headers, config) {
                    $scope.alert.status = "danger";
                    $scope.alert.message = "Error non-expected";
                });
        $http
                .get(Routing.generate('api_remotedataaccess_getrepositoryjson',
                        {
                            entityName: 'SuperAdmin-CoreBundle-Entity-Field',
                            functionName: 'findBy',
                            parameters: [{'object': $routeParams.id}]
                        }
                ))
                .success(function (data, status, headers, config) {
                    if ($scope.object === undefined) {
                        $scope.object = {};
                    }
                    $scope.object.fields = [];
                    $.each(data, function (key, value) {
                        $scope.object.fields.push(value);
                    });
                })
                .error(function (data, status, headers, config) {
                    $scope.alert.status = "danger";
                    $scope.alert.message = "Error non-expected";
                });

        //fill up select with available field type
        $scope.addField = {};
        $scope.addField.types = ctrlHelper.addFieldType;
        $scope.addField.new = $scope.addField.types[0].value; //default value

        //on click function
        $scope.addNewField = function () {
            ctrlHelper.addNewField($scope)
        };
        $scope.deleteField = function (id) {
            ctrlHelper.deleteRow($scope.object.fields, id)
        };
        $scope.saveObject = function () {
            ctrlHelper.saveObject($scope, $http, null, 'edit')
        };
    }
]);
controllers.controller('Create', ['$scope', '$http', 'ctrlHelper', '$location',
    function Create($scope, $http, ctrlHelper, $location) {
        $scope.object = {};
        $scope.object.fields = [];
        //fill up select with available field type
        $scope.addField = {};
        $scope.addField.types = ctrlHelper.addFieldType;
        $scope.addField.new = $scope.addField.types[0].value; //default value
        //on click function
        $scope.addNewField = function () {
            ctrlHelper.addNewField($scope)
        };
        $scope.deleteField = function (id) {
            ctrlHelper.deleteRow($scope.object.fields, id)
        };
        $scope.saveObject = function () {
            var valid = ctrlHelper.saveObject($scope, $http, $location, 'new');
        };
    }
]);
