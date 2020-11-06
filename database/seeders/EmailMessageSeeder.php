<?php

namespace Database\Seeders;

use App\Models\EmailMessage;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmailMessageSeeder extends Seeder
{
    private $limiter;

    public function __construct( $maxFakeLists = 5)
    {
        $this->limiter =  $maxFakeLists ;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       foreach (User::all() as $user){
           for ($i = 0; $i < $this->limiter; $i++){
               $list = EmailMessage::factory()->make();
               $list->user()->associate($user);
               $list->save();
               $list->recipients()->createMany( Recipient::factory($this->limiter)->make()->toArray());
           }
       }
    }
}
