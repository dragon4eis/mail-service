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
            'name' => $this->faker->name,
            'address' => $this->faker->unique()->safeEmail,
            'subject' => $this->faker->city,
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => $this->faker->text,
            'status' => $this->faker->randomElement([EmailMessage::STATUS_MAIL_FAILED, EmailMessage::STATUS_MAIL_SUCCESS])
        ];
    }
}
