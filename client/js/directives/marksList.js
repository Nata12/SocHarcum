/**
 * Created by Nata on 29-Oct-15.
 */
app.directive('marksList', function(TemplateUrl) {
    return {
        restrict: 'E',
        scope: {
            lecturer: "="
        },
        templateUrl: TemplateUrl.marksList
    };
});