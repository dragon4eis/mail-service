<?php


namespace App\Interfaces;


interface EmailLogging
{
    const CREATE_OPERATION = "create";
    const UPDATE_OPERATION = "update";
    const DELETE_OPERATION = "delete";
    const SEND_EMAIL_OPERATION = "send";
    const PROCESSING_EMAIL_OPERATION = "processing";
    const FAILED_TO_SEND_OPERATION = "failed";

    public function getOperation();
}