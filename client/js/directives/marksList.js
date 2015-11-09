/**
 * Created by Nata on 29-Oct-15.
 */
app.directive('marksList', function(TemplateUrl) {
    return {
        restrict: 'E',
        scope: {
            quest: "="
        },
        templateUrl: TemplateUrl.marksList,
        link:function (scope) {
            scope.questioncolour=function(number) {
                if(number%2)
                    return 'lightGray';
                else
                return 'white';
            };
        }

    };
});