/**
 * Created by Nata on 10/11/2015.
 */
app.service('LoginSvc', ['$http', function ($http) {

    logincCredentials = {
        login: "",
        groupId: 0
    };
    this.getLoginCredentials = function () {
        return logincCredentials;
    };

    this.checkLogin = function (loginParam) {
        return $http(
            {
                method: 'GET',
                url: "http://localhost/SocHarcum/server/checkLogin.php?username=" + loginParam,
                //data: [{username:loginParam}],
                //headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .success(function (data) {
                if (data.groupId && data.groupId != 0) {
                    logincCredentials.login = data.login;
                    logincCredentials.groupId = data.groupId;

                }


            })

    };

}]);
