/**
 * Created by Nata on 05/11/2015.
 */
app.controller('SurveyCtrl', ['$scope', 'LecturersSvc', 'LoginSvc', 'NavigateSvc', function ($scope, LecturersSvc, LoginSvc, NavigateSvc) {

    $scope.getLoginCredentials = LoginSvc.getLoginCredentials;

    $scope.loginCredentials = $scope.getLoginCredentials();

    if (!$scope.loginCredentials||!$scope.loginCredentials.login) {
        NavigateSvc.goToMain();
    }
    else {
        LecturersSvc.getFacultyQuestionsData($scope.loginCredentials.groupId)
            .success(function (result) {
                $scope.facultyQuestions = result.data[0];
                $scope.facultyQuestions.description = "";


                LecturersSvc.getLecturersData($scope.loginCredentials.groupId)
                    .success(function (result) {
                        $scope.lecturersData = result;

                        for (var index = 0; index < $scope.lecturersData.data.length; ++index) {
                            $scope.lecturersData.data[index].number = index + 1;
                        }

                        $scope.InsertMarks = function () {

                            LecturersSvc.postFacultyData($scope.facultyQuestions,$scope.loginCredentials.login);
                            LecturersSvc.postLecturersData($scope.lecturersData.data,$scope.loginCredentials.login);
                        };

                        $scope.pagenumber = 0;
                        $scope.pagecount = $scope.lecturersData.data.length + 1;


                        $scope.activateNext = function () {

                            if ($scope.pagenumber < $scope.pagecount) {
                                $scope.pagenumber++;
                            }
                        };
                        $scope.activatePrevious = function () {

                            if ($scope.pagenumber > 0) {
                                $scope.pagenumber--;
                            }
                        };


                        $scope.isActivePage = function (number) {
                            return number === $scope.pagenumber;
                        };


                        $scope.isFirstPage = function () {
                            return $scope.isActivePage(0);
                        };

                        $scope.isLastPage = function () {
                            return $scope.isActivePage($scope.pagecount);
                        };
                    })
                    .catch(function (error) {
                        console.log(error);
                    });


            })
            .catch(function (error) {
                console.log(error);
            });
    }

}]);
