<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',10)->comment('图片使用类型');
            $table->string('path')->comment('存储路径');
            $table->string('driver',10)->comment('驱动');
            $table->string('mime',50)->nullable()->comment('mime类型');
            $table->string('ext',10)->nullable()->comment('后缀');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
