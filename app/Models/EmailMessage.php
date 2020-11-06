<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EmailMessage extends Model
{
    use HasFactory;

    const STATUS_MAIL_NEW = 1;
    const STATUS_MAIL_IN_QUEUE = 2;
    const STATUS_MAIL_FAILED = 3;
    const STATUS_MAIL_SUCCESS = 4;

    protected $guarded = ['id'];

    public function recipients(){
        return $this->hasMany(Recipient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
