/**
 * Created by Nata on 12/11/2015.
 */
app.directive('subjectLecturers', function(TemplateUrl) {
    return {
        restrict: 'E',
        scope: {
            subject: "="
        },
        templateUrl: TemplateUrl.subjectLecturers
    };
});