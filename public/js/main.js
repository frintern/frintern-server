/**
 * Created by Toluwanimi on 25/10/2015.
 */
var app = angular.module('meetRabbi', [
    'ngRoute','ui.router'
]);

app.config(['$routeProvider','$locationProvider', function ($routeProvider, $locationProvider) {

    $routeProvider
        .when('/', { templateUrl: 'partials/landing_page/home.html'})

        .when("/login", { templateUrl: "partials/landing_page/login.html" })

}]);