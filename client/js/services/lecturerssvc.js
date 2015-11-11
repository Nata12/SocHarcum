/**
 * Created by Nata on 31/10/2015.
 */
/**
 * Created by Nata on 29-Oct-15.
 */
app.service('LecturersSvc', ['$http', function ($http) {

    var serverPath = "http://localhost/SocHarcum/server/";

    this.getLecturersData = function (groupId) {
        return $http.get(serverPath + 'getScheduleWithGroupsQuestions.php?grp=' + groupId);
    };

    this.getFacultyQuestionsData = function (groupId) {

        return $http.get(serverPath + 'getFacultyQuestions.php?grp=' + groupId);
    }

    this.postFacultyData = function (facultyQuestions, login) {

        var dataToInsert = [];

        for (indexQ = 0; indexQ < facultyQuestions.quests.length; indexQ++) {

            if (facultyQuestions.quests[indexQ].mark != -1 || facultyQuestions.description != "") {
                dataToInsert.push({
                    login: login,
                    facultyid: facultyQuestions.FacultyID,
                    qid: facultyQuestions.quests[indexQ].QuestionID,
                    mark: facultyQuestions.quests[indexQ].mark,
                    description: facultyQuestions.description
                });
            }
        }
        return $http(
            {
                method: 'POST',
                url: serverPath + "saveFacultyMarks.php",
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

    this.postLecturersData = function (subjects, login) {

        var dataToInsert = [];
        for (indexS = 0; indexS < subjects.length; indexS++) {
            for (indexL = 0; indexL < subjects[indexS].lect.length; indexL++) {
                if (subjects[indexS].lect[indexL].LectID === subjects[indexS].SelectedLectID) {
                    for (indexQ = 0; indexQ < subjects[indexS].lect[indexL].quests.length; indexQ++) {
                        if (subjects[indexS].lect[indexL].quests[indexQ].mark != -1
                            || subjects[indexS].lect[indexL].quests[indexQ].description != "") {
                            dataToInsert.push({
                                login: login,
                                subjectid: subjects[indexS].SubjID,
                                subjtype: subjects[indexS].STypeID,
                                lectid: subjects[indexS].lect[indexL].LectID,
                                qid: subjects[indexS].lect[indexL].quests[indexQ].QuestionID,
                                mark: subjects[indexS].lect[indexL].quests[indexQ].mark,
                                description: subjects[indexS].lect[indexL].quests[indexQ].description
                            });
                        }
                    }
                }
            }
        }
        return $http(
            {
                method: 'POST',
                url: serverPath + "saveLecturerMarks.php",
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
}])
;
