
/**
 * Applicants Scripts
 */
(function(angular){

    // Make sure we have the applicants panel on the page before continuing
    if (!$('#applicants-panel').length) {
        return false;
    }

    /**
     * Applicants Panel Angular Instance
     */
    var app = angular.module('applicantsPanel', []);
    app.controller('applicantsCtrl', function($scope, $http){
        // Array of all our applicants
        $scope.allApplicants = [];

        // Array of our possible job openings
        $scope.openings = [];

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
                $scope.ajaxListApplicants();

                // Users like to see that it says "loading" for a second
                setTimeout(function(){
                    $('#applicants-panel .app-view').fadeIn();
                    $scope.initialized = true;
                    $scope.$apply();
                }, 1000);
            }
            return this;
        }

        /**
         * Returns the index for a particular applicant
         * 
         * @param  object applicant
         * @return int
         */
        $scope.getIndex = function(applicant) {
            return $scope.allApplicants.indexOf(applicant);
        }

        /**
         * Cliock action to edit an applicant
         * 
         * @param  object applicant
         * @return this
         */
        $scope.editApplicant = function(applicant) {
            $scope.h2Text = "Edit Applicant #" + applicant.id;
            $scope.indexText = $scope.getIndex(applicant);
            $scope.idText = applicant.id;
            $scope.nameText = applicant.name;
            $scope.emailText = applicant.email;
            $scope.phoneText = applicant.phone;
            $scope.githubIdText = applicant.github_id;
            $scope.positionIdSelect = applicant.position_id+'';
            $scope.invitationDateText = applicant.invitation_date;
            $scope.submissionDateText = applicant.submission_date;
            $('.datepicker').datepicker();
            return this;
        };

        /**
         * Click action to delete an applicant
         * 
         * @param  object applicant
         * @return this
         */
        $scope.deleteApplicant = function(applicant) {
            if (confirm("Are you sure you which to delete applicant "+applicant.id+"?")) {
                var index = $scope.getIndex(applicant);
                $scope.allApplicants.splice($scope.getIndex(applicant), 1);
                $scope.ajaxDeleteApplicant(applicant);
            }
            return this;
        }

        /**
         * Logic for saving an applicant to both the angular instance and
         * to the database
         * 
         * @return this
         */
        $scope.saveApplicant = function() {
            // There is probably a more efficient way of doing this next part
            // and it will take more than a few hours to figure out AngularJS
            // best practices. I think I gave it a good shot, though :)
            if ($scope.indexText !== "") {
                // Edit existing
                var thisApplicant = $scope.getApplicantByIndex($scope.indexText);
                thisApplicant.id = $scope.idText;
                thisApplicant.title = $scope.titleText;
                thisApplicant.name = $scope.nameText;
                thisApplicant.email = $scope.emailText;
                thisApplicant.phone = $scope.phoneText;
                thisApplicant.github_id = $scope.githubIdText;
                thisApplicant.position_id = $scope.positionIdSelect;
                thisApplicant.invitation_date = $scope.invitationDateText;
                thisApplicant.submission_date = $scope.submissionDateText;
            } else {
                // Create new
                $scope.allApplicants.push({
                    id              : $scope.idText,
                    title           : $scope.titleText,
                    name            : $scope.nameText,
                    email           : $scope.emailText,
                    phone           : $scope.phoneText,
                    github_id       : $scope.githubIdText,
                    position_id     : $scope.positionIdSelect,
                    invitation_date : $scope.invitationDateText,
                    submission_date : $scope.submissionDateText
                });
                var thisApplicant = $scope.allApplicants[$scope.allApplicants.length-1];
            }

            // Update the server...
            $scope.ajaxSaveApplicant(thisApplicant);
            $scope.reset();

            return this;
        };

        /**
         * Searches for an applicant in the $scope.allApplicants array
         * Returns false if none found; otherwise, returns the object
         *
         * @param  int   indexId
         * @return mixed
         */
        $scope.getApplicantByIndex = function(index) {
            return $scope.allApplicants[index] || false;
        }

        /**
         * Resets the form
         * 
         * @return this
         */
        $scope.reset = function() {
            $scope.h2Text = "Create Applicant";
            $scope.indexText = "";
            $scope.idText = "";
            $scope.nameText = "";
            $scope.emailText = "";
            $scope.phoneText = "";
            $scope.githubIdText = "";
            $scope.positionIdSelect = $scope.getFirstOpening();
            $scope.invitationDate = "";
            $scope.submissionDate = "";
            $('.datepicker').datepicker();
            return this;
        }

        /**
         * Ajax action to grab list of all current applicants
         * 
         * @return this
         */
        $scope.ajaxListApplicants = function() {
            $http.get("/applicants/list")
                .then(function(response){
                    // Store all applicant data
                    $scope.allApplicants = response.data.applicants;

                    // Store all opening data
                    $.each(response.data.openings, function(k, opening){
                        if (opening.id) {
                            $scope.openings.push({
                                'text'  : opening.title,
                                'value' : opening.id
                            });
                        }
                        // Reset the select opening
                        $scope.positionIdSelect = $scope.getFirstOpening();
                    });
                }, function(){
                    alert("Error getting applicants");
                });
            return this;
        }

        /**
         * Ajax action to save an applicant to the server
         * 
         * @return string
         */
        $scope.ajaxSaveApplicant = function(applicant) {
            if (applicant) {
                $http.post("/applicants/save", {'data' : applicant})
                    .then(function(response){
                        if (!applicant.id && response.data){
                            applicant.id = response.data.id;
                        }
                    }, function(){
                        alert("Error saving applicant.");
                    });
            }
            return this;
        }

        /**
         * Ajax action to delete an applicant on the server
         * 
         * @return string
         */
        $scope.ajaxDeleteApplicant = function(applicant) {
            if (applicant) {
                $http.post("/applicants/delete", {'delete_id' : applicant.id})
                    .then(function(){}, function(){
                        alert("Error deleting applicant");
                    });
            }
        }

        /**
         * Returns the text version of this application's position
         * 
         * @return int
         */
        $scope.getPositionText = function(applicant)
        {
            var text = 'N/A';
            $.each($scope.openings, function(k, opening) {
                if (applicant.position_id === opening.value) {
                    text = opening.text;
                    return false;
                }
            });
            return text;
        }

        /**
         * Returns the value of the first opening
         * 
         * @return int
         */
        $scope.getFirstOpening = function()
        {
            return $scope.openings.length ? $scope.openings[0].value+'' : '';
        }

        // Initialize on runtime!
        $scope.init();
    });

})(window.angular);