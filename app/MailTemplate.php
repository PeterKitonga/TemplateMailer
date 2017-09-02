<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'mail_tag', 'mail_title', 'mail_subject', 'mail_body_content', 'mail_has_attachment', 'mail_attachment_name', 'mail_attachment_content'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
