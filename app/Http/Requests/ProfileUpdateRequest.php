<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'town' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'zipcode' => ['nullable', 'string', 'max:10'],
            'gender' => ['nullable', 'string', Rule::in(['Male', 'Female', 'Other'])],
            'status' => ['nullable', 'string', Rule::in(['Veteran', 'Staff'])],
            'branch' => ['nullable', 'string', Rule::in([
                'Airforce',
                'Airforce Reserve',
                'Army',
                'Army National Guard',
                'Army Reserve',
                'Coast Guard',
                'Coast Guard Reserve',
                'Marine Corps',
                'Marine Corps Reserve',
                'Navy',
                'Navy Reserve',
                'Other'
            ])],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }
}
