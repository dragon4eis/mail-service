<?php

namespace Tests\Unit;

use App\Models\EmailMessage;
use App\Models\Recipient;
use App\Models\User;
use App\Repositories\Database\EmailMessageRepository;
use App\Repositories\EmailMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EmailRepositoryTest extends TestCase
{
    protected EmailMessageRepositoryInterface $repository;
    protected EmailMessage $mail;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EmailMessageRepository(new EmailMessage());
        //create random email message
        $this->mail = EmailMessage::factory()->make();
        $this->mail->user()->associate(User::first());
        $this->mail->save();
    }

    public function testListItems()
    {
        //test full length
        $this->assertSame(
            EmailMessage::all()->count(),
            $this->repository->list()->count(),
            "test full length problem:"
        );

        //test filter
        $this->assertSame(
            EmailMessage::where('name', $this->mail->name)->get()->count(),
            $this->repository->list(['name' => $this->mail->name])->count(),
            "test search"
        );

        //test order
        $this->assertSame(
            $this->mail->id,
            $this->repository->list([], ['id' => 'desc'])->first()->id,
            "test search"
        );
    }

    public function testCreateNewItem()
    {
        $this->actingAs(User::first());
        $inputArray = EmailMessage::factory()->make()->toArray();
        $inputArray['user_id'] = Auth::user()->getAuthIdentifier();
        $inputArray['recipients'] =  Recipient::factory(10)->make()->toArray();
        $newItem = $this->repository->makeNew($inputArray);

        //check the item class instance
        $this->assertInstanceOf(
            Model::class,
            $newItem
        );

        $this->assertSame(
            10,
            $newItem->recipients()->count()
        );

        $newItem->delete();
    }

    public function testUpdateItem()
    {
        $recipientsArray = Recipient::factory(10)->make()->toArray();
        $newName = 'Test Not Real Name';
        $updatedItem = $this->repository->change(
            $this->mail->id,
            ['name' => $newName, 'recipients' => $recipientsArray]
        );

        //check the item class instance
        $this->assertInstanceOf(
            Model::class,
            $updatedItem
        );

        //check the item value
        $this->assertSame(
            EmailMessage::findOrfail($this->mail->id)->name,
            $newName,
            "Name was not updated to $newName"
        );

        //check the item value
        $this->assertNotSame(
            $this->mail->name,
            $updatedItem->name,
            "Old name is active"
        );

        //check the item value
        $this->assertSame(
            count($recipientsArray),
            EmailMessage::findOrfail($this->mail->id)->recipients()->count()
        );
    }

    public function testFindItem()
    {
        $loadItem = $this->repository->load($this->mail->id);

        //check the item class instance
        $this->assertInstanceOf(
            Model::class,
            $loadItem
        );

        //check the item value
        $this->assertSame(
            $this->mail->name,
            $loadItem->name
        );
    }

    public function testRemoveItem()
    {
        //test removing 1 item
        $this->assertTrue(
            $this->repository->delete([$this->mail->id])
        );

        //test removing multiple items
        $this->assertTrue(
            $this->repository->delete(EmailMessage::all()->take(5)->pluck('id')->toArray())
        );
    }

    protected function tearDown(): void
    {
        $this->mail->delete();
        parent::tearDown();
    }
}
