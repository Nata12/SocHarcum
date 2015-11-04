/**
 * Created by Nata on 29-Oct-15.
 */
var app = angular.module('SocHarcum', [
    'ngRoute'
]).config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl : "./../client/views/main.html",
            controller : "MainCtrl"
        })
        .when('/survey', {
            templateUrl : "./../client/views/survey.html",
            controller : "SurveyCtrl"
        })
        .otherwise({
            redirectTo : "/"
        });
}]);

