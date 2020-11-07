<?php

namespace App\Console\Commands;

use App\Classes\Mailers\EmailContent;
use App\Services\EmailMessageServiceInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateEmailCommand extends Command
{
    protected $service;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send 
                                {address : Address of the recipient} 
                                {subject : Title of the email message}
                                {message : Body of the email message} 
                                {type=text : type of the message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email using console';

    public function __construct(EmailMessageServiceInterface $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $address = $this->argument('address');

        $subject = $this->argument('subject');

        $message = $this->argument('message');

        $type = $this->argument('type');

        if (!in_array($type, $this->supportedTypes())) {
            $type = $this->choice(
                'Provided type was not found! select a type?',
                $this->supportedTypes(),
                0
            );
        }

        $validator = Validator::make($inputs = [
            'subject' => $subject,
            'message' => $message,
            'type' => $type,
            'recipients' => [
                ['address' => $address]
            ]

        ], [
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'recipients.0.address' => ['required', 'email', 'max:255'],
            'type' => ['required', 'max:10', 'in:' . implode(",", $this->supportedTypes())],
        ]);

        if ($validator->fails()) {
            $this->info('Email was not Added. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        } else {
            try {
                $mail = $this->service->makeItem($inputs);
                if ($mail) {
                    $this->info('Email message was created');
                    return 0;
                } else {
                    $this->error('Email message was  not created');
                    return 1;
                }
            } catch (Exception $exception) {
                $this->error($exception);
                return 1;
            }

        }
    }

    /**
     * Gets supported types for artisan command
     * @return array
     */
    private function supportedTypes(): array
    {
        return [
            EmailContent::MAIL_FORMAT_TEXT,
            EmailContent::MAIL_FORMAT_MARKDOWN,
            EmailContent::MAIL_FORMAT_HTML
        ];
    }
}
