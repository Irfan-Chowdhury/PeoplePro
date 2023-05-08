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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number', 191);
            $table->unsignedBigInteger('client_id')->nullable()->index('invoices_client_id_foreign');
            $table->unsignedBigInteger('project_id')->nullable()->index('invoices_project_id_foreign');
            $table->date('invoice_date');
            $table->date('invoice_due_date');
            $table->double('sub_total');
            $table->tinyInteger('discount_type')->nullable();
            $table->double('discount_figure');
            $table->double('total_tax');
            $table->double('total_discount');
            $table->double('grand_total');
            $table->mediumText('invoice_note')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
