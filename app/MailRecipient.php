<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailRecipient extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'mail_recipient_name', 'mail_recipient_email', 'mail_recipient_is_business_owner', 'mail_recipient_company_name', 'mail_recipient_company_position'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mailSchedules()
    {
        return $this->belongsToMany(MailSchedule::class, 'mail_template_schedule_recipient')->withPivot('mail_template_id');
    }
}
