<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Contact;
use App\Reply;
use App\Relation;
use App\Conversation;
use App\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Number of contact messages, sent to sidebar
        View::composer(['includes.sidebar', 'admin'], function($view){
            $view->with('contactMsgs', Contact::where('readed', NULL)->count());
        });

        // User, sent to sidebar and navbar
        View::composer(['includes.sidebar', 'includes.navbar'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('user', User::where('id', $id)->first());
        });

        // Reply message from administrator
        View::composer(['includes.navbar'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('replys', Reply::where('user_id', $id)
                                        ->where('readed', NULL)
                                        ->get());
        });

        // Reply message from administrator
        View::composer(['includes.conversations'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('replys', Reply::where('user_id', $id)
                                        ->where('deleted', NULL)
                                        ->get());
        });

        // New Relation Notification
        View::composer(['includes.navbar'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('relation', Relation::where('user_id_receive', $id)
                                            ->where('active', NULL)
                                            ->where('finished', NULL)
                                            ->where('canceled', NULL)
                                            ->where('deleted', NULL)
                                            ->get());
        });

        // Display conversations on conversations sidebar
        View::composer(['includes.conversations'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('conversations', DB::table('conversations')
                                            ->where('participant_1', '=', $id)
                                            ->where('deleted_1', '=', NULL)
                                            ->orWhere('participant_2', '=', $id)
                                            ->where('deleted_2', '=', NULL)
                                            ->join('users', 
                                                DB::raw('(
                                                    CASE WHEN 
                                                        conversations.participant_1 = ' . $id . ' 
                                                    THEN 
                                                        conversations.participant_2 
                                                    ELSE 
                                                        conversations.participant_1 
                                                    END
                                                    )'), '=', 'users.id')
                                            ->select('conversations.*','conversations.id AS conversation_id', 'users.name', 'users.lastname', 'users.image')
                                            ->orderBy('updated_at', 'desc')
                                            ->get());
        });

        // Display number of new unreaded messages
        View::composer(['includes.navbar', 'includes.conversations'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('new_messages', Message::where('user_id_to', $id)->where('readed', NULL)->count());
        });

        //Mark conversation with new messages 
        View::composer(['includes.navbar', 'includes.conversations'], function($view){
            $id = (Auth::check()) ? Auth::user()->id : NULL;

            $view->with('messages_in_conv', Message::where('user_id_to', $id)->where('readed', NULL)->get());
        });


    }
}
