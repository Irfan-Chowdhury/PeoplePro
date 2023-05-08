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
        Schema::create('finance_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable()->index('finance_expenses_company_id_foreign');
            $table->unsignedBigInteger('account_id')->nullable()->index('finance_expenses_account_id_foreign');
            $table->string('amount', 30);
            $table->unsignedBigInteger('category_id')->nullable()->index('finance_expenses_category_id_foreign');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable()->index('finance_expenses_payment_method_id_foreign');
            $table->unsignedBigInteger('payee_id')->nullable()->index('finance_expenses_payee_id_foreign');
            $table->string('expense_reference', 191);
            $table->string('expense_file', 191)->nullable();
            $table->date('expense_date');
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
        Schema::dropIfExists('finance_expenses');
    }
};
