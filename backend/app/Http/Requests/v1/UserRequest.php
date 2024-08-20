<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('users.update')) {
            // Rules for 'users.update' route
            return [
                'name' => 'required|max:255|string',
                'email' => 'required|max:255|email',
                'password' => 'sometimes|min:8'
            ];
        } else {
            // Rules for other routes
            return [
                'name' => 'required|max:255|string',
                'email' => 'required|max:255|email|unique:users,email',
                'password' => 'required|min:8'
            ];
        }
    }
}
