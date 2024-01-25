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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('kind');
            $table->foreignId('user_id')->constrained('users');
            $table->text('information');
            $table->integer('max_people');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('is_visible');
            $table->dateTime('customer_canceled_date')->nullable()->comment('コートレンタル用キャンセル日時。event_userテーブルのcanceled_dateと同時に入れる');
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
        Schema::dropIfExists('events');
    }
};
