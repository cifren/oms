var objectApp = angular.module('objectApp', [
  'ngResource',
  'ui.bootstrap',
  'clientsControllers'
]);

objectApp
        .config(['$routeProvider',
          function($routeProvider) {
            $routeProvider.
                    //advanced search list
                    when('/advancedSearch/clients/name=:name&birthDate=:birthDate&fininstitut=:fininstitut&panNumber=:panNumber&accountNumber=:accountNumber&branch=:branch', {
                      name: 'advancedClientList',
                      templateUrl: Routing.generate('cr_frontend_client_template', {templateName: 'clientList.html.twig'}),
                      controller: 'ClientListAdvCtrl'
                    }).
                    //details client from advanced list
                    when('/advancedSearch/clientDetail/:clientId/name=:name&birthDate=:birthDate&fininstitut=:fininstitut&panNumber=:panNumber&accountNumber=:accountNumber&branch=:branch', {
                      templateUrl: Routing.generate('cr_frontend_client_template', {templateName: 'clientDetails.html.twig'}),
                      controller: 'ClientDetailsAdvCtrl'
                    }).
                    otherwise({
                      redirectTo: '/'
                    });
          }
        ])
        .run(function($route, $rootScope) {
          $rootScope.path = function(controller, params)
          {
            // Iterate over all available routes
            for (var path in $route.routes)
            {
              var nameController = $route.routes[path].name;
              if (nameController === controller) // Route found
              {
                var result = path;
                // Construct the path with given parameters in it
                for (var param in params)
                {
                  result = result.replace(':' + param, params[param]);
                }
                return result;
              }
            }
            // No such controller in route definitions
            return undefined;
          };
        });
;