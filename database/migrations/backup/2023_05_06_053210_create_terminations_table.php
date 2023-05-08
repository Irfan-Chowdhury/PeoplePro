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
        Schema::create('terminations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->index('terminations_company_id_foreign');
            $table->unsignedBigInteger('terminated_employee')->index('terminations_terminated_employee_foreign');
            $table->unsignedBigInteger('termination_type')->nullable()->index('terminations_termination_type_foreign');
            $table->date('termination_date');
            $table->date('notice_date');
            $table->string('status', 40);
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
        Schema::dropIfExists('terminations');
    }
};
