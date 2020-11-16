<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_send');
            $table->integer('user_id_receive');
            $table->integer('coach_id');
            $table->boolean('active')->nullable();
            $table->boolean('finished')->nullable();
            $table->integer('canceled')->nullable();
            $table->integer('deleted')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('finished_at')->nullable();
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
        Schema::dropIfExists('relations');
    }
}
