<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recipient_email')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('mail_template_id')->unsigned();
            $table->foreign('mail_template_id')->references('id')->on('mail_templates')->onDelete('cascade');
            $table->integer('mail_schedule_id')->unsigned();
            $table->foreign('mail_schedule_id')->references('id')->on('mail_schedules')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_logs');
    }
}
