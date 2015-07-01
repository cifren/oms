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
controllers.controller('Create', ['$scope',
    function Create($scope) {
        $scope.object = {};
        $scope.object.fields = [];
        $scope.addField = {};
        $scope.addField.types = [{value: "text", name:0}, {value: "textarea", name:1}];
        $scope.addField.new = $scope.addField.types[0].name; 
        $scope.addNewField = function(){
            var field = {
                type: $scope.addField.types[$scope.addField.new].value,
                idType: $scope.addField.new,
            };
            $scope.object.fields.push(field);
        };
    }
])
        ;
