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
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_type_id')->nullable()->index('leaves_leave_type_id_foreign');
            $table->unsignedBigInteger('company_id')->index('leaves_company_id_foreign');
            $table->unsignedBigInteger('department_id')->index('leaves_department_id_foreign');
            $table->unsignedBigInteger('employee_id')->nullable()->index('leaves_employee_id_foreign');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->mediumText('leave_reason')->nullable();
            $table->string('remarks', 191)->nullable();
            $table->string('status', 40);
            $table->tinyInteger('is_notify')->nullable()->default(0);
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
        Schema::dropIfExists('leaves');
    }
};
