
/**
 * Job Openings Scripts
 */
(function(angular){

    // Make sure we have the job openings panel on the page before continuing
    if (!$('#openings-panel').length) {
        return false;
    }

    /**
     * Job Openings Panel Angular Instance
     */
    var app = angular.module('openingsPanel', []);
    app.controller('jobOpeningsCtrl', function($scope, $http){
        // Array of all our job openings
        $scope.allOpenings = [];

        // Boolen on whether we've been initialized or not
        $scope.initialized = false;

        /**
         * Initialization logic
         *
         * @return this
         */
        $scope.init = function() {
            if (!$scope.initialized){
                $scope.reset();
                $scope.ajaxListOpenings();

                // Users like to see that it says "loading" for a second
                setTimeout(function(){
                    $('#openings-panel .app-view').fadeIn();
                    $scope.initialized = true;
                    $scope.$apply();
                }, 1000);
            }
            return this;
        }

        /**
         * Returns the index for a particular opening
         * 
         * @param  object opening
         * @return int
         */
        $scope.getIndex = function(opening) {
            return $scope.allOpenings.indexOf(opening);
        }

        /**
         * Cliock action to edit an opening
         * 
         * @param  object opening
         * @return this
         */
        $scope.editOpening = function(opening) {
            $scope.h2Text = "Edit Job Opening #" + opening.id;
            $scope.indexText = $scope.getIndex(opening);
            $scope.idText = opening.id;
            $scope.titleText = opening.title;
            $scope.isAvailableCheckbox = opening.is_available;
            return this;
        };

        /**
         * Click action to delete an opening
         * 
         * @param  object opening
         * @return this
         */
        $scope.deleteOpening = function(opening) {
            if (confirm("Are you sure you which to delete job opening "+opening.id+"?")) {
                var index = $scope.getIndex(opening);
                $scope.allOpenings.splice($scope.getIndex(opening), 1);
                $scope.ajaxDeleteOpening(opening);
            }
            return this;
        }

        /**
         * Logic for saving an opening to both the angular instance and
         * to the database
         * 
         * @return this
         */
        $scope.saveOpening = function() {
            // There is probably a more efficient way of doing this next part
            // and it will take more than a few hours to figure out AngularJS
            // best practices. I think I gave it a good shot, though :)
            if ($scope.indexText !== "") {
                // Edit existing
                var thisOpening = $scope.getOpeningByIndex($scope.indexText);
                thisOpening.id = $scope.idText;
                thisOpening.title = $scope.titleText;
                thisOpening.is_available = $scope.isAvailableCheckbox ? 1 : 0;
            } else {
                // Create new
                $scope.allOpenings.push({
                    id : $scope.idText,
                    title: $scope.titleText,
                    is_available : $scope.isAvailableCheckbox ? 1 : 0
                });
                var thisOpening = $scope.allOpenings[$scope.allOpenings.length-1];
            }

            // Update the server...
            $scope.ajaxSaveOpening(thisOpening);
            $scope.reset();

            return this;
        };

        /**
         * Searches for an opening in the $scope.allOpenings array
         * Returns false if none found; otherwise, returns the object
         *
         * @param  int   indexId
         * @return mixed
         */
        $scope.getOpeningByIndex = function(index) {
            return $scope.allOpenings[index] || false;
        }

        /**
         * Resets the form
         * 
         * @return this
         */
        $scope.reset = function() {
            $scope.h2Text = "Create Job Opening";
            $scope.indexText = "";
            $scope.idText = "";
            $scope.titleText = "";
            $scope.isAvailableCheckbox = false;
            return this;
        }

        /**
         * Ajax action to grab list of all current openings
         * 
         * @return this
         */
        $scope.ajaxListOpenings = function() {
            $http.get("/job-openings/list")
                .then(function(response){
                    $scope.allOpenings = response.data;
                }, function(){
                    alert("Error getting job openings");
                });
            return this;
        }

        /**
         * Ajax action to save an opening to the server
         * 
         * @return string
         */
        $scope.ajaxSaveOpening = function(opening) {
            if (opening) {
                $http.post("/job-openings/save", {'data' : opening})
                    .then(function(response){
                        if (!opening.id && response.data){
                            opening.id = response.data.id;
                        }
                    }, function(){
                        alert("Error saving job opening");
                    });
            }
            return this;
        }

        /**
         * Ajax action to delete an opening on the server
         * 
         * @return string
         */
        $scope.ajaxDeleteOpening = function(opening) {
            if (opening) {
                $http.post("/job-openings/delete", {'delete_id' : opening.id})
                    .then(function(){}, function(){
                        alert("Error deleting job opening");
                    });
            }
        }

        // Initialize on runtime!
        $scope.init();
    });

})(window.angular);