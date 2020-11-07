<?php


use App\Classes\Mailers\EmailContent;
use App\Models\EmailMessage;
use App\Models\User;
use App\Repositories\Database\EmailMessageRepository;
use App\Services\EmailMessageService;
use App\Services\EmailMessageServiceInterface;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class EmailMessageServiceTest extends TestCase
{
    private EmailMessageServiceInterface $service;

    public function testReformatInput()
    {
        //set unfinished input array
        $inputs = [
            'subject' => 'test subject',
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => 'random@exmaple.com'
                ]
            ]
        ];

        //execute format
        $formattedArray = $this->service->reformatInputs($inputs);

        //validate reformatted array
        $this->assertArrayHasKey("name", $formattedArray);
        $this->assertSame('random', $formattedArray['recipients'][0]['name']);
    }

    public function testSaveEmail()
    {
        //set inputs array
        $inputs = [
            'subject' => 'test subject',
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => 'random@exmaple.com'
                ]
            ]
        ];

        //save email
        $saved = $this->service->makeItem($inputs);

        //validate email class and values
        $this->assertInstanceOf(
            Model::class,
            $saved
        );

        $this->assertSame(
            'random',
            $saved->recipients->first()->name
        );

        $saved->delete();
    }

    public function testEditEmail()
    {

        //get random element
        $inputs = (EmailMessage::with('recipients')->first())->toArray();
        $inputs['name'] = 'test name';

        //change element
        $update = $this->service->editItem($inputs['id'], $inputs);

        //check if valid
        $this->assertSame(
            $inputs['name'],
            $update->name
        );
    }

    public function testFindEmail()
    {
        $this->assertSame(
            ($mail = EmailMessage::with('recipients')->first())->toArray(),
            $this->service->findItem($mail->id)->toArray(),
        );

        $this->assertSame(
            (EmailMessage::with('recipients')->first())->recipients->count(),
            $this->service->findItem($mail->id)->recipients->count()
        );
    }

    public function testListing()
    {

        $mail = EmailMessage::first();

        //test full length
        $this->assertSame(
            EmailMessage::all()->count(),
            $this->service->listItems()->count(),
            "test full length problem:"
        );

        //test filter
        $this->assertSame(
            EmailMessage::where('name', $mail->name)->get()->count(),
            $this->service->listItems(['name' => $mail->name])->count(),
            "test search"
        );

        //test order
        $this->assertSame(
            EmailMessage::orderBy('id', 'desc')->first()->id,
            $this->service->listItems([], ['id' => 'desc'])->first()->id,
            "test search"
        );
    }

    public function testDeleteItem()
    {
        $this->assertTrue(
            $this->service->remove([EmailMessage::first()->id])
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new  EmailMessageService(new EmailMessageRepository(new EmailMessage()));
    }


}