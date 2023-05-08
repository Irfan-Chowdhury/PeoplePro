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
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('promotion_title', 40);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->index('promotions_company_id_foreign');
            $table->unsignedBigInteger('employee_id')->index('promotions_employee_id_foreign');
            $table->date('promotion_date');
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
        Schema::dropIfExists('promotions');
    }
};
