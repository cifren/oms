objectApp
        .directive('fieldtypeText', function () {
            return {
                restrict: 'E',
                templateUrl: Routing.generate('api_common_templateaccess',
                        {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:Directive/Type/text.html.twig')}
                )
            }
        })
        .directive('fieldtypeTextarea', function () {
            return {
                restrict: 'E',
                templateUrl: Routing.generate('api_common_templateaccess',
                        {templateName: encodeURIComponent('SuperAdminInterfaceBundle:Object:Directive/Type/textarea.html.twig')}
                )
            }
        })
        ;