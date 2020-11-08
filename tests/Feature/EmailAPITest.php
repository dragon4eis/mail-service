<?php

namespace Tests\Feature;

use App\Classes\Mailers\EmailContent;
use App\Models\EmailMessage;
use App\Models\Recipient;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailAPITest extends TestCase
{

    private array $inputs;
    
    private User $user;

    public function testCreate(){
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/mail', $this->inputs);

        $response->assertStatus(201)
            ->assertJsonCount(2)
            ->assertJsonFragment(["message" => "Email Message {$this->inputs['subject']} was successfully created"]);
    }

    public function testList(){

        $response = $this->actingAs($this->user, 'api')
            ->get('/api/mail');

        $response->assertStatus(200);
    }

    public function testRead(){
        $message =  EmailMessage::orderBy('id', 'desc')->first();

        $response = $this
            ->actingAs($this->user, 'api')
            ->getJson("/api/mail/{$message->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(["id" => $message->id]);
    }

    public function testUpdate(){
        $newName = 'Test Not Real Name';
        $message =  EmailMessage::orderBy('id', 'desc')->first();
        $this->inputs['subject'] = $newName;

        $response = $this
            ->actingAs($this->user, 'api')
            ->putJson("/api/mail/{$message->id}", $this->inputs);


        $response->assertStatus(200)
            ->assertJson(['resource' =>['subject' => $newName]]);
    }

    public function testDelete(){
        $message =  EmailMessage::orderBy('id', 'desc')->first();

        $response = $this
            ->actingAs($this->user, 'api')
            ->delete("/api/mail/{$message->id}");

        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::findOrFail(1);
        $this->setEmailMessage();
    }

    /**
     * Sets up inputs array for API tests
     */
    private function setEmailMessage(){
        $this->inputs = [
            'subject' => 'test subject',
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => config('mail.mail_for_tests')
                ]
            ]
        ];
    }
}
