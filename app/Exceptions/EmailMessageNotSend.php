<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class EmailMessageNotSend extends Exception
{

    public  function report(){
        Log::error("Email message was not send with the service!");
    }
}
