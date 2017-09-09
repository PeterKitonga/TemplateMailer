<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderColumnToMailRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_recipients', function (Blueprint $table) {
            $table->integer('mail_recipient_gender')->nullable()->after('mail_recipient_email'); // Female: 1, Male: 2
            $table->string('mail_recipient_title')->nullable()->after('mail_recipient_gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_recipients', function (Blueprint $table) {
            $table->dropColumn(['mail_recipient_gender', 'mail_recipient_title']);
        });
    }
}
