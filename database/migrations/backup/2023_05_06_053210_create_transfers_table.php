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
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->index('transfers_company_id_foreign');
            $table->unsignedBigInteger('from_department_id')->nullable()->index('transfers_from_department_id_foreign');
            $table->unsignedBigInteger('to_department_id')->nullable()->index('transfers_to_department_id_foreign');
            $table->unsignedBigInteger('employee_id')->nullable()->index('transfers_employee_id_foreign');
            $table->date('transfer_date');
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
        Schema::dropIfExists('transfers');
    }
};
