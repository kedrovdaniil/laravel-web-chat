<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatsController extends Controller
{
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
//        dd('we are here!');
        $userId = Auth::id();
//        $userId = 1;
        $chatsForUser = Chat::with(['members'])->whereHas('members', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('deleted_at', null);
        })->get();

        return ChatResource::collection($chatsForUser);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'string|nullable',
            'avatar_url' => 'nullable',
            'members' => 'required'
        ]);

        // create a chat
//        $log = !empty($request->name) ? $request->name : null;
//        Log::info('log = '.(int) !empty($request->name));
        $initiatorId = Auth::id();
        $chat = new Chat();
        $chat->name = !empty($request->name) ? $request->name : null;
        $chat->avatar_url = null;
        $chat->created_by_user_id = $initiatorId;
        $chat->managed_by_user_id = $initiatorId;
//        $result = $chat->save();
//        Log::info('result = '.$result);

        // add members for the chat
        $members = json_decode($request->members);
        $membersCount = count($members);
//        Log::info($members);

        if ($membersCount > 1) {
            if ($request->avatar_url) {
                $chat->avatar_url = $request->avatar_url;
            } else {
                $chat->avatar_url = '/group.png';
            }
            $result = $chat->save();
        } else {
            $chat->avatar_url = User::find($members[0]->id)->avatar_url;
            $result = $chat->save();
        }
        $usersIds = array_map(function ($member) {
            return $member->id;
        }, $members);
        $results = collect($usersIds)->push(Auth::id())->unique()->map(function ($id) use ($chat) {
            $member = new ChatUser();
            $member->chat_id = $chat->id;
            $member->user_id = $id;
            return $member->save();
        })->toArray();

        if (!in_array(false, $results)) {
            return $this->successResponse('OK', [
                'result' => true
            ], 200);
        } else {
            return $this->errorResponse('Something went wrong on server. Please, send a message about this problem to a support.');
        }
    }

    /**
     * Add member to the chat
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMember($id, Request $request)
    {
        // validation
        $request->validate([
            'userId' => 'string|nullable',
        ]);

        // add member
        $member = new ChatUser();
        $member->chat_id = $id;
        $member->user_id = (int) $request->userId;
        $result = $member->save();

        return $this->successResponse('OK', [
            'result' => $result
        ]);
    }

    /**
     * Remove member from the chat
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeMember($id, Request $request)
    {
        // validation
        $request->validate([
            'userId' => 'string|nullable',
        ]);

        // remove member
        $result = ChatUser::where('user_id', $request->userId)->where('chat_id', $id)->delete();

        return $this->successResponse('OK', [
            'result' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($id)
    {
        $userId = 1;
        $messages = Message::where('chat_id', $id)->where('deleted_at', null)->latest()->paginate(25);

//        $messageResource = new MessageResource($messages);
        return MessageResource::collection($messages);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editName($id, Request $request)
    {
        // validation
        $request->validate([
            'name' => 'nullable|string'
        ]);

        // get the chat
        $chat = Chat::find($id);

        // if name changed save it
        $result = true;
        if (!empty($request->name)) {
            $chat->name = $request->name;
            $result = $chat->save();
        }

        return $this->successResponse("OK", [
            'result' => $result
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $chat = Chat::with('members')->find($id);

        // initiator
        $initiatorId = Auth::id();

        // delete user from chat
        $membersIds = $chat->members->modelKeys();
        $countOfMembers = count($membersIds);
        $isPublicChat = $countOfMembers > 2;
//        Log::info('$membersIds = ');
//        Log::info($membersIds);


        // 1. проверить есть ли такой пользователь в чате
        $result = null;
        if (in_array($initiatorId, $membersIds)) {
            if ($isPublicChat) {
                $isManager = $chat->managed_by_user_id === $initiatorId;
                if ($isManager) {
                    $chat->managed_by_user_id = collect($membersIds)->filter(function ($memerId) use ($initiatorId) {return $memerId !== $initiatorId;})->first();
                    $result = ChatUser::where('user_id', $initiatorId)->where('chat_id', $id)->delete();
                } else {
                    $result = ChatUser::where('user_id', $initiatorId)->where('chat_id', $id)->delete();
                }
            } else {
                if ($countOfMembers === 1) {
                    $chat->delete();
                } else {
                    $result = ChatUser::where('user_id', $initiatorId)->where('chat_id', $id)->delete();
                }
            }
        } else {
            return $this->errorResponse("You don't have permission for delete the chat.", 403);
        }

        return $this->successResponse('OK', [
            'result' => $result
        ]);

        // 2. проверить, есть ли ещё пользователи в чате и передать им роль админа



        // 3. проверить, если пользователь остался в чате один, то вообще удалить чат

    }
}
