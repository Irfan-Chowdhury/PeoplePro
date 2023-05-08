<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index('resignations_company_id_foreign');
            $table->unsignedBigInteger('department_id')->nullable()->index('resignations_department_id_foreign');
            $table->unsignedBigInteger('employee_id')->nullable()->index('resignations_employee_id_foreign');
            $table->date('notice_date')->nullable();
            $table->date('resignation_date');
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
        Schema::dropIfExists('resignations');
    }
};
