<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		//$this->call(StudentsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
		//$this->call(ServantsTableSeeder::class);
		//$this->call(CallsTableSeeder::class);
		//$this->call(AttachmentsTableSeeder::class);
		$this->call(SubjectsTableSeeder::class);
		//$this->call(AdjustmentsTableSeeder::class);
    }
}
