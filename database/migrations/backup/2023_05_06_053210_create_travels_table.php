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
        Schema::create('travels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->index('travels_company_id_foreign');
            $table->unsignedBigInteger('employee_id')->index('travels_employee_id_foreign');
            $table->unsignedBigInteger('travel_type')->nullable()->index('travels_travel_type_foreign');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('purpose_of_visit', 191)->nullable();
            $table->string('place_of_visit', 191)->nullable();
            $table->string('expected_budget', 20)->nullable();
            $table->string('actual_budget', 20)->nullable();
            $table->string('travel_mode', 20);
            $table->string('status', 30);
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
        Schema::dropIfExists('travels');
    }
};
