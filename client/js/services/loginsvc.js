/**
 * Created by Nata on 10/11/2015.
 */
app.service('LoginSvc', ['$http', function ($http) {

    this.checkLogin=function(loginParam){
        return $http(
            {
                method: 'GET',
                url: "http://localhost/SocHarcum/server/checkLogin.php?username="+loginParam//,
                //data: [{username:loginParam}],
                //headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
    };

}]);
