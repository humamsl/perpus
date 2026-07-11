<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('book.update') ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('book')?->id;
        return [
            'isbn'             => ['required','string','max:20', Rule::unique('books','isbn')->ignore($id)],
            'title'            => ['required','string','max:255'],
            'subtitle'         => ['nullable','string','max:255'],
            'publisher_id'     => ['nullable','exists:publishers,id'],
            'book_category_id' => ['nullable','exists:book_categories,id'],
            'shelf_id'         => ['nullable','exists:shelves,id'],
            'year_published'   => ['nullable','integer','between:1500,'.date('Y')],
            'edition'          => ['nullable','string','max:20'],
            'language'         => ['nullable','string','max:10'],
            'pages'            => ['nullable','integer','min:1'],
            'cover'            => ['nullable','image','max:5120'],
            'synopsis'         => ['nullable','string'],
            'keywords'         => ['nullable','string','max:255'],
            'authors'          => ['nullable','array'],
            'authors.*'        => ['integer','exists:authors,id'],
        ];
    }
}
