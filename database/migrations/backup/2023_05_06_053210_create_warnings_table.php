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
        Schema::create('warnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 191);
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('company_id')->index('warnings_company_id_foreign');
            $table->unsignedBigInteger('warning_to')->index('warnings_warning_to_foreign');
            $table->unsignedBigInteger('warning_type')->nullable()->index('warnings_warning_type_foreign');
            $table->date('warning_date');
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
        Schema::dropIfExists('warnings');
    }
};
