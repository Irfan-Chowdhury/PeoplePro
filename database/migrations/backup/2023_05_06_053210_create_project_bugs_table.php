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
        Schema::create('project_bugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->index('project_bugs_project_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('project_bugs_user_id_foreign');
            $table->mediumText('title');
            $table->string('bug_attachment', 191)->nullable();
            $table->string('status', 191)->default('pending');
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
        Schema::dropIfExists('project_bugs');
    }
};
