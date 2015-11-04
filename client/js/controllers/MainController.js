/**
 * Created by Nata on 29-Oct-15.
 */
app.controller('MainController', ['$scope', 'LecturersSvc', function($scope, LecturersSvc) {
    LecturersSvc.getLecturersData()
        .success(function(result){
            $scope.lecturersData = result;
        })
        .catch(function(error){
            console.log(error);
        });
}]);
