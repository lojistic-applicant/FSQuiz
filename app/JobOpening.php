<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    // Disable created_at and updated_at
    public $timestamps = false;
    
    // Allow all fields to be fillable
    protected $fillable = ['title', 'is_available'];

    /**
     * Returns the applicants associated with the Job Opening
     * 
     * @return App\Applicant
     */
    public function applicants()
    {
        return $this->hasMany('App\Applicants');
    }
}
