<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['recipient_email', 'user_id', 'mail_template_id', 'mail_schedule_id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mailTemplate()
    {
        return $this->belongsTo(MailTemplate::class);
    }

    public function mailSchedule()
    {
        return $this->belongsTo(MailSchedule::class);
    }
}
