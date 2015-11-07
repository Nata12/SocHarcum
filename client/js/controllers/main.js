/**
 * Created by Nata on 29-Oct-15.
 */
app.controller('MainCtrl', function ($scope, NavigateSvc) {
    $scope.goToSurvey = NavigateSvc.goToSurvey;
});
