<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this);
//        dd($this->messages->paginate(25));

        $messages = Message::where('chat_id', $this->id)->latest()->paginate(25);
        $messagesCount = Message::where('chat_id', $this->id)->where('deleted_at', null)->count();
        $pages = ceil($messagesCount / 25);

//        dd($messages);

        return [
            "id" => $this->id,
            "name" => empty($this->name) ? null : $this->name,
            "created_by_user_id" => $this->created_by_user_id,
            "managed_by_user_id" => $this->managed_by_user_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
//            "messages" => MessageResource::collection($this->messages->latest()->paginate(25)),
            "messages" => [
                "data" => MessageResource::collection($messages),
                "messagesCount" => $messagesCount,
                "pages" => $pages
            ],
            "countOfMembers" => $this->members->count(),
            "members" => $this->members,
            "avatar_url" => $this->avatar_url,

        ];
    }
}
