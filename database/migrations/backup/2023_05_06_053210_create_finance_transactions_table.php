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
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable()->index('finance_transactions_company_id_foreign');
            $table->unsignedBigInteger('account_id')->nullable()->index('finance_transactions_account_id_foreign');
            $table->string('amount', 30);
            $table->string('category', 30);
            $table->unsignedBigInteger('category_id')->nullable()->index('finance_transactions_category_id_foreign');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable()->index('finance_transactions_payment_method_id_foreign');
            $table->unsignedBigInteger('payee_id')->nullable()->index('finance_transactions_payee_id_foreign');
            $table->unsignedBigInteger('payer_id')->nullable()->index('finance_transactions_payer_id_foreign');
            $table->string('expense_reference', 191)->nullable();
            $table->string('expense_file', 191)->nullable();
            $table->date('expense_date')->nullable();
            $table->string('deposit_reference', 191)->nullable();
            $table->string('deposit_file', 191)->nullable();
            $table->date('deposit_date')->nullable();
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
        Schema::dropIfExists('finance_transactions');
    }
};
