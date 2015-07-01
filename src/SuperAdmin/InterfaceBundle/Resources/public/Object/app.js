var objectApp = angular.module('objectApp', [
    'ngResource',
    'ngRoute',
    'controllers'
]);

objectApp
        .config(['$routeProvider',
            function ($routeProvider) {
                $routeProvider.
                        when('/list', {
                            name: 'list',
                            templateUrl: Routing.generate('api_templateaccess',
                                    {templateName: 'SuperAdminInterfaceBundle:Object:list.html.twig'}
                            ),
                            controller: 'List'
                        }).
                        when('/create', {
                            name: 'create',
                            templateUrl: Routing.generate('api_templateaccess',
                                    {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:edit.html.twig')}
                            ),
                            controller: 'Create'
                        }).
                        when('/edit', {
                            name: 'edit',
                            templateUrl: Routing.generate('api_templateaccess',
                                    {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:edit.html.twig')}
                            ),
                            controller: 'Edit'
                        }).
                        otherwise({
                            redirectTo: '/list'
                        });
            }
        ]);
;