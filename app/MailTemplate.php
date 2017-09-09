<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'mail_tag',
        'mail_title',
        'mail_subject',
        'mail_body_content',
        'mail_has_attachment',
        'mail_has_attachment_file',
        'mail_attachment_file_variables',
        'mail_attachment_file_variable_values',
        'mail_attachment_file_url',
        'mail_attachment_name',
        'mail_attachment_content'
    ];

    protected $casts = [
        'mail_attachment_file_variables' => 'array',
        'mail_attachment_file_variable_values' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mailSchedules()
    {
        return $this->hasMany(MailSchedule::class);
    }

    public function mailLogs()
    {
        return $this->hasMany(MailLog::class);
    }
}
