<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => isEmpty($this->name) ? null : $this->name,
            "created_by_user_id" => $this->created_by_user_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
//            "messages" => $this->messages,
            "countOfMembers" => $this->members->count(),
            "members" => $this->members,
            "avatar_url" => $this->avatar_url
        ];
    }
}
