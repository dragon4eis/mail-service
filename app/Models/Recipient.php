<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Recipient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function emailMessage(){
      return  $this->belongsTo(EmailMessage::class);
    }
}
