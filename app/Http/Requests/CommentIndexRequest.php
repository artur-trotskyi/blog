<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentIndexRequest extends FormRequest
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
        return [
            'postId' => ['required', 'string', Rule::exists('posts', 'id')],
            'itemsPerPage' => ['required', 'integer', 'min:-1'],
            'page' => ['required', 'integer', 'min:1'],
            'sortBy' => ['sometimes', 'nullable', 'string', Rule::in(['created_at', 'username', 'email'])],
            'orderBy' => ['sometimes', 'nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}
