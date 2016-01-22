@extends('layouts/1column')

@section('content')

<h1>Applicants</h1>

<div id="applicants-panel" class="row panel" ng-app="applicantsPanel" ng-controller="applicantsCtrl">
    <div class="col-sm-12 loading" ng-show="!initialized">
        Loading, please wait...
    </div>

    <div class="col-sm-3 app-view" ng-show="initialized">
        <form ng-submit="saveApplicant()">
            <h2>@{{ h2Text }}</h2>
            <input type='hidden' ng-model="idText" id='id'>
            <input type='hidden' ng-model="indexText" id='id'>
            <div class="form-group">
                <label for='name'>Name<em>*</em></label>
                <input type='text' class="form-control" ng-required="true" ng-model='nameText'>
            </div>
            <div class="form-group">
                <label for='email'>Email<em>*</em></label>
                <input type='text' class="form-control" ng-required="true" ng-model='emailText'>
            </div>
            <div class="form-group">
                <label for='phone'>Phone</label>
                <input type='text' class="form-control" ng-model='phoneText'>
            </div>
            <div class="form-group">
                <label for='github_id'>Github ID</label>
                <input type='text' class="form-control" ng-model='githubIdText'>
            </div>
            <div class="form-group">
                <label for='position_id'>Position<em>*</em></label>
                <select class="form-control" ng-model='positionIdSelect' ng-required="true">
                    <option ng-repeat="opening in openings" value="@{{ opening.value }}">
                        @{{ opening.text }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for='invitation_date'>Invitation Date</label>
                <input type='text' class="form-control datepicker" data-date-format="yyyy-mm-dd" ng-model='invitationDateText'>
            </div>
            <div class="form-group">
                <label for='submission_date'>Submission Date</label>
                <input type='text' class="form-control datepicker" data-date-format="yyyy-mm-dd" ng-model='submissionDateText'>
            </div>
            <button type="submit" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" ng-click="reset()">Reset</button>
        </form>
    </div>
    <div class="col-sm-9 app-view" ng-show="initialized">
        <h2>Current Applicants</h2>
        <p class='no-found' ng-show="!allApplicants.length">
            There are currently no applicants. Try creating one!
        </p>
        <table class='table table-striped' ng-show="allApplicants.length">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>Github ID</th>
                    <th>Position</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="applicant in allApplicants">
                    <td>
                        @{{ applicant.id }}
                        <img src='{!! url('images/spinner.gif') !!}' ng-show="!applicant.id" />
                    </td>
                    <td>@{{ applicant.name }}</td>
                    <td>
                        <a href="mailto:@{{ applicant.email }}">
                            @{{ applicant.email }}
                        </a>
                        <br>
                        @{{ applicant.phone }}
                    </td>
                    <td>
                        <a href="http://github.com/@{{ applicant.github_id }}" target="_blank">
                            @{{ applicant.github_id }}
                        </a>
                    </td>
                    <td>@{{ getPositionText(applicant) }}</td>
                    <td>
                        <a href="javascript: false;"
                            ng-click="editApplicant(applicant)"
                            ng-show="applicant.id">Edit</a>
                        <a href="javascript: false;"
                            ng-click="deleteApplicant(applicant)"
                            ng-show="applicant.id">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop
