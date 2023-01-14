<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap = 'comment';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var \App\Models\Comment $this */
        return [
            'id'        => $this->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'body'      => $this->body,
            'author'    => new ProfileResource($this->author),
        ];
    }
}
