<?php

namespace App\Http\Requests\V1;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        $comment = Comment::find($this->route('comment'));
        $post = $comment->post;
        return $user->tokenCan('soft-delete') || ($comment->user === $user) || ($post->user); //admin or author
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
