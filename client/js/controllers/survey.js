/**
 * Created by Nata on 05/11/2015.
 */
app.controller('SurveyCtrl', ['$scope', 'LecturersSvc', function($scope, LecturersSvc) {
    LecturersSvc.getLecturersData()
        .success(function(result){
            $scope.lecturersData = result;
        })
        .catch(function(error){
            console.log(error);
        });
}]);
