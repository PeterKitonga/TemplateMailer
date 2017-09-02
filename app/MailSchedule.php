<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'mail_template_id', 'schedule_date', 'schedule_time'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mailTemplate()
    {
        return $this->belongsTo(MailTemplate::class);
    }

    public function mailLogs()
    {
        return $this->hasMany(MailLog::class);
    }

    public function mailRecipients()
    {
        return $this->belongsToMany(MailRecipient::class, 'mail_template_schedule_recipient')->withPivot('mail_template_id');
    }
}
