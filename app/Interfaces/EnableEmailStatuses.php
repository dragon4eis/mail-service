<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface EnableEmailStatuses
{
    const STATUS_MAIL_NEW = 1;
    const STATUS_MAIL_IN_QUEUE = 2;
    const STATUS_MAIL_FAILED = 3;
    const STATUS_MAIL_SUCCESS = 4;

    /**
     * Get email message status
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set email as new
     *
     * @return Model
     */
    public function setNewStatus(): Model;

    /**
     * Set email as failed
     *
     * @return Model
     */
    public function setFailedStatus(): Model;

    /**
     * Set email in Queue state
     *
     * @return Model
     */
    public function setInQueueStatus(): Model;

    /**
     * Set successfully send email
     * @return Model
     */
    public function setSucceedStatus(): Model;

    /**
     * Return information about sender
     * @return array
     */
    public function getFromAttribute(): array;
}
