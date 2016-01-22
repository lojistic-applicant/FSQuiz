<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Disable FK Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Call Seeders
        $this->call(JobOpeningsSeeder::class);
        $this->call(ApplicantsSeeder::class);

        // Reenable FK Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}

class JobOpeningsSeeder extends Seeder
{
    public function run()
    {
        App\JobOpening::truncate();
        App\JobOpening::create([
            'title'              => 'Lojistic CODEMASTER!!!!!!!!!',
            'is_available'      => 1
        ]);
        factory(App\JobOpening::class, 4)->create();
    }
}

class ApplicantsSeeder extends Seeder
{
    public function run()
    {
        App\Applicant::truncate();
        App\Applicant::create([
            'name'          => 'Alessandro Bassi',
            'email'         => 'apbassi89@gmail.com',
            'phone'         => '949 682 5405',
            'github_id'     => 'apbassi89',
            'position_id'   => 1
        ]);
        factory(App\Applicant::class, 9)->create();
    }
}
