<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EmailLog extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'create_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function email_message(){
        $this->belongsTo(EmailMessage::class);
    }
}
