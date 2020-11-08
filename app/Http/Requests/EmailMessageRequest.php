<?php

namespace App\Http\Requests;

use App\Classes\Mailers\EmailContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmailMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'address' => 'nullable|email',
            'subject' => 'required|string',
            'message' => 'required',
            'type' => 'required|in:' . implode(",", $this->supportedTypes()),
            'recipients' => 'required|array',
            'recipients.*.name' => 'string',
            'recipients.*.address' => 'required|email'
        ];
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
