<?php


namespace App\Repositories\Database;


use App\Models\EmailLog;
use App\Repositories\EmailLogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EmailLogRepository extends BaseRepository implements EmailLogRepositoryInterface
{
    public function __construct(EmailLog $model)
    {
        parent::__construct($model);
    }

   public function change($id, array $attributes): Model
   {
      throw new \Exception("Logs cannot be changed");
   }

   public function delete(array $ids): bool
   {
       throw new \Exception("Logs cannot be removed");
   }
}