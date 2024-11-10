<?php

namespace App\Http\Requests\V1;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        $post = Post::find($this->route('post'));
        return ($post->user === $user); //only the author can edit the post
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'title' => ['required', 'string', 'max:255'],
                'body' => ['required', 'string']
            ];
        } else if ($method == 'PATCH') {

            return [
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'body' => ['sometimes', 'required', 'string']
            ];
        }
    }
}
