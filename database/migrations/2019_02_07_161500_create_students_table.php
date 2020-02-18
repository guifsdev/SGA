<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
			
            $table->string('enrolment_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cpf');
            $table->string('cell_phone_number')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('email_secondary')->nullable();
			$table->string('curriculum');
			$table->integer('total_workload');
			$table->integer('obtained_workload');
			$table->integer('attended_workload');
			$table->float('percentage_completed', 5, 2);
			$table->float('performance_coeficient', 3, 2);
			$table->string('current_status');
			$table->timestamp('crawled_at');
			$table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
