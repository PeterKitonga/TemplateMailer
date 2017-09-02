<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('mail_tag', 40)->nullable();
            $table->string('mail_title', 40)->nullable();
            $table->string('mail_subject', 40)->nullable();
            $table->text('mail_body_content')->nullable();
            $table->boolean('mail_has_attachment')->default(0);
            $table->string('mail_attachment_name', 40)->nullable();
            $table->text('mail_attachment_content')->nullable();
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
        Schema::dropIfExists('mail_templates');
    }
}
