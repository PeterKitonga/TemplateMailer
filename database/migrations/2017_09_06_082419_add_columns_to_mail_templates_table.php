<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->boolean('mail_has_attachment_file')->default(0)->after('mail_has_attachment');
            $table->string('mail_attachment_file_url')->nullable()->after('mail_has_attachment_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->dropColumn(['mail_has_attachment_file', 'mail_attachment_file_url']);
        });
    }
}
