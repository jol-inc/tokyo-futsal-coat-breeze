<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained('users');
          $table->foreignId('event_id')->constrained('events');
          $table->integer('number_of_people');
          $table->datetime('canceled_date')->nullable();
          $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_user');
    }
};
