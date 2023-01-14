<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'username' => $this->username,
            'email'    => $this->email,
            'bio'      => $this->bio,
            'image'    => $this->image,
        ];
    }

    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @param  string  $token
     * @return array
     */
    public function withToken(string $token)
    {
        $this->additional([
            self::$wrap => [
                'token' => $token
            ],
        ]);
        return $this;
    }
}
