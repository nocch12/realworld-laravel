<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'article.title'       => 'required|max:255',
            'article.description' => 'required|max:255',
            'article.body'        => 'required',
            'article.tagList'     => 'nullable|array',
            'article.tagList.*'   => 'sometimes|string',
        ];
    }

    public function makeArticle()
    {
        return new Article([
            'title'       => $this->validated('article.title'),
            'description' => $this->validated('article.description'),
            'body'        => $this->validated('article.body'),
        ]);
    }

    public function makeTags()
    {
        $tags = $this->validated('article.tagList', []);
        return collect($tags)->each(function (string $name) {
            return new Tag(['name' => $name]);
        });
    }
}
