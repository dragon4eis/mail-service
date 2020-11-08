<?php

namespace Tests\Feature;

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

    public function testCreate(){
        $response = $this->postJson('/api/mail', $this->inputs);

        $response->assertStatus(201)
            ->assertJsonCount(2)
            ->assertJsonFragment(["message" => "Email Message {$this->inputs['subject']} was successfully created"]);
    }

    public function testList(){

        $response = $this->get('/api/mail');

        $response->assertStatus(200);
    }

    public function testRead(){
        $message =  EmailMessage::order_by('id', 'desc')->first();

        $response = $this->getJson("/api/mail/{$message->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $message->id]);
    }

    public function testUpdate(){
        $newName = 'Test Not Real Name';
        $message =  EmailMessage::order_by('id', 'desc')->first();
        $this->inputs['subject'] = $newName;

        $response = $this->putJson("/api/mail/{$message->id}", $this->inputs);

        $response->assertStatus(200)
            ->assertJson(['resource' =>['subject' => $newName]]);
    }

    public function testDelete(){
        $message =  EmailMessage::order_by('id', 'desc')->first();

        $response = $this->delete("/api/mail/{$message->id}");

        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::first());
        $this->setEmailMessage();
    }

    /**
     * Sets up inputs array for API tests
     */
    private function setEmailMessage(){
        $this->inputs = [
            'subject' => 'test subject',
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => 'random@exmaple.com'
                ]
            ]
        ];
    }
}
