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
        Schema::create('salary_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->index('salary_loans_employee_id_foreign');
            $table->string('month_year', 50);
            $table->date('first_date')->nullable();
            $table->string('loan_title', 191);
            $table->string('loan_amount', 191);
            $table->string('loan_type', 191);
            $table->string('loan_time', 191);
            $table->string('amount_remaining', 191);
            $table->string('time_remaining', 191);
            $table->string('monthly_payable', 50);
            $table->mediumText('reason')->nullable();
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
        Schema::dropIfExists('salary_loans');
    }
};
