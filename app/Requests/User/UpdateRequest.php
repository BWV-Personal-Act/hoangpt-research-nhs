<?php

namespace App\Requests\User;

use App\Rules\{CheckAlphaNum, CheckMaxLength, CheckMinLength, CheckValueInRange};
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'name' => [
                'required',
                new CheckMaxLength('User Name', 100),
            ],
            'email' => [
                'required',
                'email',
                new CheckMaxLength('Email', 255),
            ],
            'group_id' => 'required',
            'started_date' => 'required|date',
            'position_id' => [
                'required',
                new CheckValueInRange(0, 3),
            ],
            'password' => [
                new CheckMinLength('Password', 8),
                new CheckMaxLength('Password', 20),
                new CheckAlphaNum('Password'),
            ],
        ];
    }
}
