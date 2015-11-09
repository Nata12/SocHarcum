/**
 * Created by Nata on 04-Nov-15.
 */
app.directive('lecturerQuestions', function(TemplateUrl) {
    return {
        restrict: 'E',
        scope: {
            lecturer: "="
        },
        templateUrl: TemplateUrl.lecturerQuestions
    };
});