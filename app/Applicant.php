<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    // Disable created_at and updated_at
    public $timestamps = false;
    
    // Allow all fields to be fillable
    public $fillable = ['name', 'email', 'phone', 'github_id', 'position_id', 'invitation_date', 'submission_date'];

    /**
     * Returns the related JobOpening for this applicant
     * 
     * @return App\Applicant
     */
    public function position()
    {
        return $this->hasOne('App\JobOpening');
    }

    /**
     * Add "before save" logic.
     * Any more complex, and this should be moved to an event listener.
     * 
     * @param  array  $options 
     * @return bool
     */
    public function save(array $options = [])
    {
        // Set invitation_date to current time if empty
        if (empty($this->invitation_date)) {
            $this->invitation_date = date("Y-m-d H:i:s");
        }

        // Set invitation_date to current time if empty
        if (empty($this->submission_date)) {
            $this->submission_date = date("Y-m-d H:i:s");
        }

        return parent::save($options);
    }
}
