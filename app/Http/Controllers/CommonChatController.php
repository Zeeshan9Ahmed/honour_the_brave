<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\User\Chat\SearchChatRequest;
use Illuminate\Support\Facades\DB;

class CommonChatController extends Controller
{
    public function chatList()
    {

        return apiSuccessMessage('Chat List ', collect($this->chat(auth()->id())));
    }
    // public function searchChat(SearchChatRequest $request) {
    //     $key_word = $request->key_word;
    //     $chat_list = collect($this->chat(auth()->id()))->filter(function ($chat) use ($key_word) {

    //         return false !== stripos($chat->full_name, $key_word);
    //     });

    //     return apiSuccessMessage("Chat List ", $chat_list->values());

    // }
    public function chat($user_id)
    {
        $get_chat_list_1 = DB::table('chats')->select(
            'users.id',
            'users.full_name',
            'users.avatar',
            'users.role',
            'chats.chat_id',
            DB::raw('(select chat_message  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_message'),
            DB::raw('(select chat_sender_id  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as sender_id'),
            DB::raw('(select chat_type  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_type'),
            // 'chats.created_at'
        )
            ->selectRaw('DATE_FORMAT(chats.created_at, "%M %d, %Y") as created_at')
            ->leftJoin('users', 'users.id', '=', 'chats.chat_reciever_id')
            ->where('users.deleted_at', null)
            ->whereRaw('( chat_id in (select MAX(chat_id) from chats where chats.chat_sender_id = "'.$user_id.'" group by chat_sender_id , chat_reciever_id )  )');

        $get_chat_list_2 = DB::table('chats')->select(
            'users.id',
            'users.full_name',
            'users.avatar',
            'users.role',
            'chats.chat_id',
            DB::raw('(select chat_message  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_message'),
            DB::raw('(select chat_sender_id  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as sender_id'),
            DB::raw('(select chat_type  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_type'),
            // 'chats.created_at'
        )
            ->selectRaw('DATE_FORMAT(chats.created_at, "%M %d, %Y") as created_at')

            ->leftJoin('users', 'users.id', '=', 'chats.chat_sender_id')
            ->where('users.deleted_at', null)
            ->whereRaw('( chat_id in (select MAX(chat_id) from chats where chats.chat_reciever_id = "'.$user_id.'" group by chat_sender_id , chat_reciever_id )  )')
            ->union($get_chat_list_1);
        // return;
        $groupby = DB::query()->fromSub($get_chat_list_2, 'p_pn')
            ->select(
                'id',
                'full_name',
                'avatar',
                'role',
                'chat_id',
                'sender_id',
                'chat_message',
                'chat_type',
                'created_at'
            )
            ->orderBy('chat_id', 'desc')
            ->get();

        $data = [];

        foreach (collect($groupby)->groupBy('id') as $result) {
                $data[] = $result[0];

        }

        return $data;
    }
}
