<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\JobOpening;
use App\Traits\AjaxUpdate;

class JobOpenings extends Controller
{
    /**
     * Returns listing of job openings
     * 
     * @return Illuminate\View\View
     */
    function getJobOpenings() {
        return view('job-openings');
    }

    /**
     * Gets all Job Openings
     * 
     * @return string
     */
    function listJobOpenings() {
        $openings = JobOpening::all();
        return $openings->toJson();
    }

    /**
     * Saves a job opening, and returns the opening back as JSON
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    function saveJobOpening(Request $request) {
        $data = $request->input('data');
        if (isset($data['id']) && !empty($data['id'])) {
            $opening = JobOpening::find($data['id']);
        } else {
            unset($data['id']);
            $opening = JobOpening::create($data);
        }
        $opening->save();
        return $opening->toJson();
    }

    /**
     * Saves a job opening, and returns the opening back as JSON
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    function deleteJobOpening(Request $request) {
        $id = $request->input('delete_id');
        if (!empty($id)) {
            JobOpening::find($id)->delete();
        }
        return '';
    }
}
