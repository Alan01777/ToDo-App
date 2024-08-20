<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        if ($this->routeIs('tasks.update')) {
            // Rules for 'tasks.update' route
            return [
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'sometimes|string|in:pending,completed',
                'due_date' => 'nullable|date',
                'priority' => 'required|integer|min:1|max:5',
                'tag_id' => 'nullable',
                'category_id' => 'nullable',
            ];
        } else {
            // Rules for other routes
            return [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|string|in:pending,completed',
                'due_date' => 'nullable|date',
                'priority' => 'required|integer|min:1|max:5',
                'tag_id' => 'nullable',
                'category_id' => 'nullable',
            ];
        }
    }
}
