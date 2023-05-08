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
        Schema::create('payslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('payslip_key', 36);
            $table->string('payslip_number', 191)->nullable();
            $table->unsignedBigInteger('employee_id')->index('payslips_employee_id_foreign');
            $table->unsignedBigInteger('company_id');
            $table->string('payment_type', 191);
            $table->double('basic_salary');
            $table->double('net_salary');
            $table->text('allowances');
            $table->text('commissions');
            $table->text('loans');
            $table->text('deductions');
            $table->text('overtimes');
            $table->text('other_payments');
            $table->string('pension_type', 50)->nullable();
            $table->double('pension_amount');
            $table->integer('hours_worked');
            $table->tinyInteger('status');
            $table->string('month_year', 15);
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
        Schema::dropIfExists('payslips');
    }
};
