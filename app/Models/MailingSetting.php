<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailingSetting extends Model
{
    protected $table = 'mailing_settings';
    protected $fillable = ['key', 'value'];
    public $timestamps = true;
}
