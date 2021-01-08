<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_appraisals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('company')->nullable();
            $table->string('employee')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('customer_experience')->nullable();
            $table->string('marketing')->nullable();
            $table->string('administration')->nullable();
            $table->string('professionalism')->nullable();
            $table->string('integrity')->nullable();
            $table->string('attendance')->nullable();
            // $table->string('remarks')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('employee_appraisals');
    }
}
