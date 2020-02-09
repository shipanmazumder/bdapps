<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('install_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name',50)->unique();
            $table->string('app_id',50)->unique();
            $table->string('password',200);
            $table->smallInteger('category_id');
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
        Schema::dropIfExists('install_apps');
    }
}
