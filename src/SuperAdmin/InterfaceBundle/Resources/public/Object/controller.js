var controllers = angular.module('controllers', []);

controllers.controller('List', ['$scope', '$location',
    function List($scope, $location) {
    }
]);
controllers.controller('Edit', ['$scope',
    function Edit($scope) {
        console.log('edit');
    }
]);
controllers.controller('Create', ['$scope', '$http', '$sce',
    function Create($scope, $http, $sce) {
        $scope.object = {};
        $scope.object.fields = [];
        $scope.addField = {};
        $scope.addField.types = [{value: "text", name: 0}, {value: "textarea", name: 1}];
        $scope.addField.new = $scope.addField.types[0].name;
        $scope.addNewField = function () {
            var field = {
                type: $scope.addField.types[$scope.addField.new].value,
                idType: $scope.addField.new,
            };
            $scope.object.fields.push(field);
        };
        $scope.saveObject = function () {
            $http
                    .post(Routing.generate('superadmin_api_object_save'), {formObject: $scope.object})
                    .success(function (data, status, headers, config) {
                        $scope.alert = {};
                        if (data.status === 2) {//validation error
                            $scope.alert.status = "danger";
                            var aryMessage = [];
                            $.each(data.validatorErrorList, function (key, value) {
                                aryMessage.push("Group: " + value.class + " Field: " + value.propertyPath + " Message: " + value.message);
                            });
                            var message = aryMessage.join('<br>');
                            $scope.alert.message = $sce.trustAsHtml(message);
                        } else if (data.status === 1) {//success
                            $scope.alert.status = "success";
                            $scope.alert.message = data.message;
                        } else {//unexpected
                            $scope.alert.status = "danger";
                            $scope.alert.message = "Error non-expected";
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $scope.alert.status = "danger";
                        $scope.alert.message = "Error non-expected";
                    });
        };
    }
])
        ;
