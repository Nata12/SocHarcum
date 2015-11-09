/**
 * Created by Nata on 05/11/2015.
 */
app.controller('SurveyCtrl', ['$scope', 'LecturersSvc', function ($scope, LecturersSvc) {
    //$scope.questionValues = [
    //    [
    //        {
    //            value: "1",
    //            text: "Այո"
    //        },
    //        {
    //            value: "2",
    //            text: "Ոչ"
    //        }
    //    ],
    //    [
    //        {
    //            value: 1,
    //            text: "1"
    //        },
    //        {
    //            value: 2,
    //            text: "2"
    //        },
    //        {
    //            value: 3,
    //            text: "3"
    //        },
    //        {
    //            value: 4,
    //            text: "4"
    //        },
    //        {
    //            value: 5,
    //            text: "5"
    //        }
    //
    //    ]
    //
    //];


    LecturersSvc.getFacultyQuestionsData()
        .success(function (result) {
            $scope.facultyQuestions = result.data[0];
            $scope.facultyQuestions.description = "";


            LecturersSvc.getLecturersData()
                .success(function (result) {
                    $scope.lecturersData = result;

                    for (var index = 0; index < $scope.lecturersData.data.length; ++index) {
                        $scope.lecturersData.data[index].number = index + 1;
                    }

                    $scope.InsertMarks = function () {

                        LecturersSvc.postFacultyData($scope.facultyQuestions);
                        LecturersSvc.postLecturersData($scope.lecturersData.data);
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


}]);
