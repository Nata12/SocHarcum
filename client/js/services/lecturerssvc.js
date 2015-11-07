/**
 * Created by Nata on 31/10/2015.
 */
/**
 * Created by Nata on 29-Oct-15.
 */
app.service('LecturersSvc', ['$http', function ($http) {
    this.getLecturersData = function () {
        return $http.get('http://localhost/SocHarcum/server/getScheduleWithGroupsQuestions.php?grp=55684');
    };

    this.getFacultyQuestionsData = function () {

        return $http.get('http://localhost/SocHarcum/server/getFacultyQuestions.php?grp=55684');
    }

    this.postFacultyData = function (facultyQuestions) {

        var dataToInsert = [];

        for (indexQ = 0; indexQ < facultyQuestions.quests.length; indexQ++) {

            dataToInsert.push({
                login: '1234567',
                facultyid: facultyQuestions.FacultyID,
                qid: facultyQuestions.quests[indexQ].QuestionID,
                mark: facultyQuestions.quests[indexQ].mark,
                description: facultyQuestions.description
            });
        }
        return $http(
            {
                method: 'POST',
                url: "http://localhost/SocHarcum/server/saveFacultyMarks.php",
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

    this.postLecturersData = function (lecturers) {

        var dataToInsert = [];
        for (indexL = 0; indexL < lecturers.length; indexL++) {
            for (indexQ = 0; indexQ < lecturers[indexL].quests.length; indexQ++) {
                dataToInsert.push({
                    login: '1234567',
                    subjectid: lecturers[indexL].SubjID,
                    subjtype: lecturers[indexL].STypeID,
                    lectid: lecturers[indexL].LectID,
                    qid: lecturers[indexL].quests[indexQ].QuestionID,
                    mark: lecturers[indexL].quests[indexQ].mark,
                    description: lecturers[indexL].quests[indexQ].description
                });
            }
        }
        return $http(
            {
                method: 'POST',
                url: "http://localhost/SocHarcum/server/saveLecturerMarks.php",
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
