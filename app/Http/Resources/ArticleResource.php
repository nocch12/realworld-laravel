<?php

namespace App\Http\Resources;

use \App\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Article $this */
        return [
            'slug'           => $this->slug,
            'title'          => $this->title,
            'description'    => $this->description,
            'body'           => $this->body,
            'tagList'        => $this->tags->pluck('name'),
            'createdAt'      => $this->created_at,
            'updatedAt'      => $this->updated_at,
            'favorited'      => false,
            'favoritesCount' => 0,
            'author'         => []
        ];
    }
}
