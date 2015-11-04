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
}]);
