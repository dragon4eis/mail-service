<?php

namespace Database\Factories;

use App\Classes\Mailers\EmailContent;
use App\Models\EmailMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from_name' => $this->faker->name,
            'from_email' => $this->faker->unique()->safeEmail,
            'subject' => $this->faker->city,
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => $this->faker->text
        ];
    }
}
