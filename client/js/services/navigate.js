/**
 * Created by Nata on 05/11/2015.
 */
app.service('NavigateSvc', function($window, Pages) {
    var _goToPage = function(page) {
        $window.location.hash = page;
    };

    this.goToSurvey = function() {
        _goToPage(Pages.survey);
    };
})