<?php


namespace App\Repositories\Database;



use App\Models\EmailMessage;
use App\Repositories\EmailMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class EmailMessageRepository extends BaseRepository implements EmailMessageRepositoryInterface
{
    public function __construct(EmailMessage $model)
    {
        parent::__construct($model);
    }

    public function makeNew(array $attributes): Model
    {
        $mail = parent::makeNew($attributes);
        $mail->recipients()->createMany($attributes['recipients']);
        return $mail;
    }

    public function change($id, array $attributes): Model
    {
        $mail = parent::change($id, $attributes);
        $mail->recipients()->delete();
        $mail->recipients()->createMany($attributes['recipients']);
        return $mail;
    }
}