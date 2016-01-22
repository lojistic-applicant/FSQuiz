<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->string('email', 256);
            $table->string('phone', 32);
            $table->string('github_id', 64);
            $table->integer('position_id')->unsigned();
            $table->boolean('is_available');
            $table->date('invitation_date');
            $table->date('submission_date');

            // Add FKEY Relationship
            $table->foreign('position_id')
                ->references('id')
                ->on('job_openings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
