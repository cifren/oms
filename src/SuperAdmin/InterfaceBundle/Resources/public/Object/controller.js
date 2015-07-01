var controllers = angular.module('controllers', []);

controllers.controller('List', ['$scope', '$location',
    function List($scope, $location) {
        console.log('list');
    }
]);
controllers.controller('Edit', ['$scope', '$location',
    function List($scope, $location) {
        console.log('edit');
    }
]);
controllers.controller('Create', ['$scope', '$location',
    function List($scope, $location) {
        console.log('create');
    }
]);
