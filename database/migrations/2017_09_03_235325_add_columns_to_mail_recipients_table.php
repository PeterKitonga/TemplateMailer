<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMailRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_recipients', function (Blueprint $table) {
            $table->boolean('mail_recipient_is_business_owner')->default(0)->after('mail_recipient_email');
            $table->string('mail_recipient_company_name')->nullable()->after('mail_recipient_is_business_owner');
            $table->string('mail_recipient_company_position')->nullable()->after('mail_recipient_company_name');
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
            $table->dropColumn(['mail_recipient_is_business_owner', 'mail_recipient_company_name', 'mail_recipient_company_position']);
        });
    }
}
