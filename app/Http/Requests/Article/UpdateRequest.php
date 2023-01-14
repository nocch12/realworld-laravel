<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'article.title'       => 'sometimes|max:255',
            'article.description' => 'sometimes|max:255',
            'article.body'        => 'sometimes|nullable',
        ];
    }

    public function makeArticle(Article $article)
    {
        return $article->fill([
            'title'       => $this->validated('article.title', $article->title),
            'description' => $this->validated('article.description', $article->description),
            'body'        => $this->validated('article.body', $article->body),
        ]);
    }
}
