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
        Schema::create('salary_overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->index('salary_overtimes_employee_id_foreign');
            $table->string('month_year', 50);
            $table->date('first_date')->nullable();
            $table->string('overtime_title', 191);
            $table->string('no_of_days', 191);
            $table->string('overtime_hours', 191);
            $table->string('overtime_rate', 191);
            $table->string('overtime_amount', 191);
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
        Schema::dropIfExists('salary_overtimes');
    }
};
