<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammingLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programming_languages')->insert([
            ['name' => 'C++', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Java', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'PHP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'React', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Android', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Laravel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
