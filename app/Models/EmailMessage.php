<?php

namespace App\Models;

use App\Interfaces\EnableEmailStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class EmailMessage extends Model implements EnableEmailStatuses
{
    use HasFactory;

    protected  $guarded = ['id'];

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }
    /**
     * Get email message status
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->getAttribute('status') || null;
    }

    public function setFailedStatus(): Model{
        $this->update(['status' => self::STATUS_MAIL_FAILED]);
        return $this;
    }

    public function setNewStatus(): Model
    {
        $this->update(['status' => self::STATUS_MAIL_NEW]);
        return $this;
    }

    public function setInQueueStatus(): Model
    {
        $this->update(['status' => self::STATUS_MAIL_IN_QUEUE]);
        return $this;
    }

    public function setSucceedStatus(): Model
    {
        $this->update(['status' => self::STATUS_MAIL_SUCCESS]);
        return $this;
    }

    public function getFromAttribute(): array
    {
        return [
            'name' => $this->getAttribute('name'),
            'address' => $this->getAttribute('address')
        ];
    }
}
