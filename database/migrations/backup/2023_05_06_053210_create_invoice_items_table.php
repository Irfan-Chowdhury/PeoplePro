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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id')->nullable()->index('invoice_items_invoice_id_foreign');
            $table->unsignedBigInteger('project_id')->nullable()->index('invoice_items_project_id_foreign');
            $table->string('item_name', 191);
            $table->string('item_tax_type', 191);
            $table->string('item_tax_rate', 191);
            $table->bigInteger('item_qty')->default(0);
            $table->bigInteger('item_unit_price');
            $table->double('item_sub_total');
            $table->double('sub_total');
            $table->tinyInteger('discount_type')->nullable();
            $table->double('discount_figure');
            $table->double('total_tax');
            $table->double('total_discount');
            $table->double('grand_total');
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
        Schema::dropIfExists('invoice_items');
    }
};
