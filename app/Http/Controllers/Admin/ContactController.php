<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use App\Contact;
use App\Reply;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware(['auth', 'admin']);
    }

    /*
     * Show contact messages page
     */
    public function index()
    {
        // Contact messages
        $contact_msgs = Contact::with(['user', 'reply'])
                                ->where('deleted', NULL)
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        return view('admin/cont-msgs')->with('contact_msgs', $contact_msgs);
    }

    /*
     * Read the message.
     */
    public function read($id)
    {
        $contact_msg = Contact::with('reply')->find($id);
        $contact_msg->readed = 1;
        $contact_msg->save();

        return view('admin/read')->with('msg', $contact_msg);
    }

    /*
     * Reply message.
     */
    public function reply(Request $request, $id)
    {
        $contact_msg = Contact::find($id);

        if($contact_msg->readed === NULL)
            $contact_msg->readed = 1;

        $contact_msg->replied = 1;
        
        if($contact_msg->save())
        {
            $reply_msg = new Reply;
            $reply_msg->contact_id = $request->input('contact_id');
            $reply_msg->user_id = $request->input('user_id');
            $reply_msg->admin_id = Auth::user()->id;
            $reply_msg->reply_msg = $request->input('reply_msg');
            $reply_msg->save();
        }

        return redirect()->to(url()->previous())->with('success', 'You replied on message');
    }

    /*
     * Show deleted contact message page
     */
    public function deleted()
    {
        // Deleted messages
        $contact_msgs = Contact::with(['user', 'reply'])
                                ->where('deleted', 1)
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);

        return view('admin/deleted')->with('contact_msgs', $contact_msgs);
    }

    /*
     * Delete message
     */
    public function delete($id)
    {
        $contact = Contact::find($id);

        if($contact->readed === NULL)
            $contact->readed = 1;

        $contact->deleted = 1;
        $contact->save();

        return redirect()->to('admin/cont-msgs')->with('success', 'Message was succassfully deleted');;
    }
}
