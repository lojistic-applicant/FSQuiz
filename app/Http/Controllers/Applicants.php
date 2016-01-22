<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Applicant;
use App\JobOpening;

class Applicants extends Controller
{
    /**
     * Returns listing of job openings
     * 
     * @return Illuminate\View\View
     */
    function getApplicants() {
        return view('applicants');
    }

    /**
     * Gets all Applicants
     * 
     * @return string
     */
    function listApplicants() {
        $data = [
            'applicants' => Applicant::all()->toArray(),
            'openings'   => JobOpening::all()->toArray(),
        ];

        return json_encode($data);
    }

    /**
     * Saves an applicant, and returns the applicant back as JSON
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    function saveApplicant(Request $request) {
        $data = $request->input('data');
        if (isset($data['id']) && !empty($data['id'])) {
            $applicant = Applicant::find($data['id']);
        } else {
            unset($data['id']);
            $applicant = Applicant::create($data);
        }
        $applicant->save();
        return $applicant->toJson();
    }

    /**
     * Saves an applicant, and returns the applicant back as JSON
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    function deleteApplicants(Request $request) {
        $id = $request->input('delete_id');
        if (!empty($id)) {
            Applicant::find($id)->delete();
        }
        return '';
    }
}
