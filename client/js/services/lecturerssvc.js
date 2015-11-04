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
    this.postLecturersData = function(){
        var req = {
            /*  method: 'POST',
             url: 'http://example.com',
             headers: {
             'Content-Type': undefined
             },
             data: {*/
            login :'123456',
            subjectid:1,
            subjtype:16,
            lectid:123456489,
            qid:10,
            mark:3 ,
            description :'djfhjdsh'
            //}
        };

        return $http.post('http://localhost/SocHarcum/server/insertMark.php',req);
    };
}]);
