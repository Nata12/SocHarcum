/**
 * Created by Nata on 31/10/2015.
 */
/**
 * Created by Nata on 29-Oct-15.
 */
app.service('LecturersSvc', ['$http', function($http) {
    this.getLecturersData = function(){
        return $http.get('http://localhost/SocHarcum/server/select.php');
    };

    this.postLecturersData = function(lecturers) {

        var dataToInsert = [];
        for (indexL = 0; indexL < lecturers.length; indexL++) {
            for (indexQ = 0; indexQ < lecturers[indexL].quests.length; indexQ++) {
                dataToInsert.push({
                    login: '1234567',
                    subjectid: lecturers[indexL].SubjectID,
                    subjtype: lecturers[indexL].ExamTypeId,
                    lectid: lecturers[indexL].lecturerid,
                    qid: lecturers[indexL].quests[indexQ].QuestionID,
                    mark: lecturers[indexL].quests[indexQ].mark,
                    description: 'newtestDescription'
                });
            }
        }
        return $http(
            {
                method: 'POST',
                url: "http://localhost/SocHarcum/server/insertMarks.php",
                data: dataToInsert,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .success(function (result) {
                console.log(result);
            })
            .catch(function (error) {
                console.log(error);
            });
    };
}]);
