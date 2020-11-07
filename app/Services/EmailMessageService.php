<?php


namespace App\Services;

use App\Events\EmailCreate;
use App\Repositories\EmailMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EmailMessageService extends BaseRepositoryService implements EmailMessageServiceInterface
{
    public function __construct(EmailMessageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function makeItem(array $inputs): ?Model
    {
        $emailMessage = parent::makeItem($this->reformatInputs($inputs));
        EmailCreate::dispatch($emailMessage);
        return $emailMessage;
    }

    public function reformatInputs(array $inputArray): array
    {
        $inputArray['address'] = $inputArray['address'] ?? config('mail.from.address');
        $inputArray['name'] = $inputArray['name'] ?? config('mail.from.name');
        foreach ($inputArray['recipients'] as $key => &$value) {
            if (!isset($value['name'])) {
                $value['name'] = explode("@", $value['address'])[0];
            }
        }
        return $inputArray;
    }

    public function editItem($id, array $inputs): ?Model
    {
        return parent::editItem($id, $this->reformatInputs($inputs));
    }


}