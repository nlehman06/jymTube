<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider');
            $table->string('provider_id')->index();
            $table->string('title');
            $table->text('description');
            $table->string('permalink_url');
            $table->time('length');
            $table->string('picture');
            $table->dateTime('created_time');
            $table->string('from_id');
            $table->string('from_name');
            $table->string('from_profile');
            $table->integer('submitted_by_user_id')->index();
            $table->dateTime('submitted_date');
            $table->string('status');
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
        Schema::dropIfExists('videos');
    }
}
