<?php

namespace App\Http\Requests;

use App\Rules\AllowedHtmlTags;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentStoreRequest extends FormRequest
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
            'text' => ['required', 'string', new AllowedHtmlTags()],
            'postId' => ['required', 'string', Rule::exists('posts', 'id')],
            'parentCommentId' => ['sometimes', 'nullable', 'string',
                Rule::exists('comments', 'id')->where(function ($query) {
                    $query->where('post_id', request('postId'));
                })],
        ];
    }
}
