<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Conversation;
use App\Message;
use App\Reply;

class PrivateMessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user_coach']);
    }

    /* 
     * Get all informations on private messages page 
     */
    public function index()
    {
        $messages = [];
        $admin_messages = [];

        return view('messages/messages')->with([
            'messages' => $messages,
            'admin_messages' => $admin_messages
            ]);
    }

    /* 
     * Show messages for particular conversation 
     */
    public function show_messages($conv_id)
    {
        $user_id = Auth::user()->id;

        // Messages
        $messages = DB::table('messages')
                    ->join('conversations', 'messages.conversation_id', '=', 'conversations.id')
                    ->join('users', 'messages.user_id_from', '=', 'users.id')
                    ->where('conversations.id', '=', $conv_id)
                    ->where(
                        DB::raw('(
                            CASE WHEN 
                                messages.user_id_from = ' . $user_id . ' 
                            THEN 
                                messages.user_from_deleted = 1 
                            ELSE 
                                messages.user_to_deleted = 1  
                            END
                            )'))
                    ->select('messages.*', 'conversations.*','conversations.participant_1 AS user_from', 'conversations.participant_2 AS user_to', 'users.*')
                    ->get();

        // Unreaded messages
        $unreaded_messages = self::unreaded_messages($conv_id);
 
        //Loop through unreaded messages, and set it to readed 
        foreach($unreaded_messages as $message)
        {
            $message = Message::find($message->id);
            $message->readed = 1;
            $message->save();
        }
            
        return view('messages/messages')->with([
            'messages' => $messages
            ]);
    }

    /* 
     * Get all unreaded messages 
     */
    public static function unreaded_messages($id)
    {
        $messages = Message::where('conversation_id', $id)
                            ->where('user_id_to', Auth::user()->id)
                            ->where('readed', NULL)
                            ->get();

        return $messages;
    }

    /* 
     * Create new conversation 
     */
    public function create_conversation(Request $request)
    {
        $request->validate([
            'msg_body' => ['required'],
        ]);

        $conversation = new Conversation;
        $conversation->participant_1 = Auth::user()->id;
        $conversation->participant_2 = $request->input('msg_to');

        // If conversation sucassfully saved
        if($conversation->save())
        {
            $conv_id = $conversation->id;

            //Save first message
            $this->save_message($conv_id, $request->input('msg_to'), $request->input('msg_body'));
            $messages = self::get_messages($conv_id);
        }

        return redirect()->to('messages/' . $conv_id)->with([
            'messages' => $messages,
            'conv_id' => $conv_id
            ]);
    }

    /* 
     * Get all messages for last created conversation 
     */
    public static function get_messages($conv_id)
    {
        $messages = DB::table('messages')
                    ->join('conversations', 'messages.conversation_id', '=', 'conversations.id')
                    ->join('users', 'messages.user_id_from', '=', 'users.id')
                    ->where('conversations.id', '=', $conv_id)
                    ->select('messages.*', 'conversations.*', 'users.*')
                    ->get();

        return $messages;
    }

    /* 
     * Save first message for new conversation 
     */
    public function save_message($conv_id, $msg_to, $msg_body)
    {
        $message = new Message;
        $message->conversation_id = $conv_id;
        $message->user_id_from = Auth::user()->id;
        $message->user_id_to = $msg_to;
        $message->text = $msg_body;
        $message->save();
    }

    /* 
     * Message reply 
     */
    public function reply_message(Request $request)
    {
        $request->validate([
            'reply-msg' => ['required'],
        ]);

        $message = new Message;
        $message->conversation_id = $request->input("conversation_id");
        $message->user_id_from = Auth::user()->id;
        $message->user_id_to = $request->input("msg_to");
        $message->text = $request->input("reply-msg");
        
        // If message is sucassfilly saved
        if($message->save())
        {
            // Update conversation
            $conversation = Conversation::find($request->input('conversation_id'));
            if($conversation->participant_1 === Auth::user()->id && $conversation->deleted_2 === 1)
                $conversation->deleted_2 = NULL;
            else
                $conversation->deleted_1 = NULL;

            $conversation->updated_at = date('Y-m-d H:i:s');
            $conversation->save();
        }

        return redirect()->to('messages/' . $request->input("conversation_id"));
    }

    /* 
     * Delete conversation 
     */
    public function delete_conversation($conv_id)
    {
        $conversation = Conversation::find($conv_id);
        if($conversation->participant_1 === Auth::user()->id)
            $conversation->deleted_1 = 1;
        else
            $conversation->deleted_2 = 1;

        if($conversation->save())
        {
            $messages = Message::where('conversation_id', $conv_id)->get();
      
            foreach ($messages as $message) {
                if($message->user_id_from === Auth::user()->id)
                    $message->user_from_deleted = 1;
                else
                    $message->user_to_deleted = 1;

                $message->save();
            }
        }
        return redirect()->to('messages');
    }

    /* 
     * Show message from admin
     * This message is admin's response to user's contact form message
     */
    public function show_admin_messages($reply_id)
    {
        $admin_messages = DB::table('contacts')
                        ->where('contacts.user_id', '=', Auth::user()->id)
                        ->join('replies', 'contacts.user_id', '=', 'replies.user_id')
                        ->where('replies.id', '=', $reply_id)
                        ->select('contacts.name', 'contacts.lastname', 'contacts.message', 'contacts.created_at', 'replies.id AS reply_id', 'replies.reply_msg', 'replies.created_at AS replied_at')
                        ->get();

        //Unreaded message
        $unreaded_admins_message = self::unreaded_admins_message($reply_id);

        //If message is not null, find that row and set it to readed
        if($unreaded_admins_message !== NULL){
            $message = Reply::find($unreaded_admins_message->id);
            $message->readed = 1;
            $message->save();
        }
        return view('messages/messages')->with([
            'admin_messages' => $admin_messages,
        ]);
    }

    /* 
     * Get admin's unreaded message 
     */
    public static function unreaded_admins_message($id)
    {
        $message = Reply::where('id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->where('readed', NULL)
                    ->first();

        return $message;
    }

    /* 
     * Delete admin's message 
     */
    public function delete_admin_message($reply_id)
    {
        $reply = Reply::find($reply_id);
        $reply->deleted = 1;
        $reply->save();

        return redirect()->to('messages');
    }
}
