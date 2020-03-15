<?php

use Illuminate\Database\Seeder;

class AdjustmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Adjustment::class, 100)->create();
    }
}
