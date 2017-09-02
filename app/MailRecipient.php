<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailRecipient extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'mail_recipient_name', 'mail_recipient_email'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
