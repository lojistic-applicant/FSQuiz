@extends('layouts/1column')

@section('content')

<h1>Job Openings</h1>

<div id="openings-panel" class="row panel" ng-app="openingsPanel" ng-controller="jobOpeningsCtrl">
    <div class="col-sm-12 loading" ng-show="!initialized">
        Loading, please wait...
    </div>
    <div class="col-sm-4 app-view" ng-show="initialized">
        <form ng-submit="saveOpening()">
            <h2>@{{ h2Text }}</h2>
            <input type='hidden' ng-model="idText" id='id'>
            <input type='hidden' ng-model="indexText" id='id'>
            <div class="form-group">
                <label for='title'>Title<em>*</em></label>
                <input type='text' ng-required="true" class="form-control" ng-model='titleText' id='title'>
            </div>
            <div class="form-group">
                <input type='checkbox' ng-model="isAvailableCheckbox" id='is_available'>
                <label for='is_available'>Is Available?</label>
            </div>
            <button type="submit" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" ng-click="reset()">Reset</button>
        </form>
    </div>
    <div class="col-sm-8 app-view" ng-show="initialized">
        <h2>Current Job Openings</h2>
        <p class='no-found' ng-show="!allOpenings.length">
            There are currently no job openings. Try creating one!
        </p>
        <table class='table table-striped' ng-show="allOpenings.length">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Is Available?</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="opening in allOpenings">
                    <td>
                        @{{ opening.id }}
                        <img src='{!! url('images/spinner.gif') !!}' ng-show="!opening.id" />
                    </td>
                    <td>@{{ opening.title }}</td>
                    <td>@{{ opening.is_available ? "Yes" : "No" }}</td>
                    <td>
                        <a href="javascript: false;"
                            ng-click="editOpening(opening)"
                            ng-show="opening.id">Edit</a>
                        <a href="javascript: false;"
                            ng-click="deleteOpening(opening)"
                            ng-show="opening.id">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop
