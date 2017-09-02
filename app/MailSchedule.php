<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'mail_template_id', 'schedule_date', 'schedule_time'];

    protected $dates = ['deleted_at'];
}
