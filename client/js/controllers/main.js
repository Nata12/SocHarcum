/**
 * Created by Nata on 29-Oct-15.
 */
app.controller('MainCtrl', ['$scope','LoginSvc','NavigateSvc', function ($scope,LoginSvc, NavigateSvc) {
    $scope.loginParam="";
    $scope.loginError=false;

    $scope.checkLogin=function() {
        LoginSvc.checkLogin($scope.loginParam)
            .success(function (data) {
               if(data.groupId && data.groupId!=0) {

                   NavigateSvc.goToSurvey();
               }
               else {

                   $scope.loginError = true;
               }



            })
    };


}]);
