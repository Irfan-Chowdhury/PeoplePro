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
        Schema::create('finance_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable()->index('finance_transfers_company_id_foreign');
            $table->unsignedBigInteger('from_account_id')->nullable()->index('finance_transfers_from_account_id_foreign');
            $table->unsignedBigInteger('to_account_id')->nullable()->index('finance_transfers_to_account_id_foreign');
            $table->string('amount', 30);
            $table->string('reference', 191);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable()->index('finance_transfers_payment_method_id_foreign');
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
        Schema::dropIfExists('finance_transfers');
    }
};
