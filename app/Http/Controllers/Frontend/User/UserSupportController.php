<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Support\CloseSupportTicketRequest;
use App\Http\Requests\Frontend\User\Support\ReplySupportTicketRequest;
use App\Http\Requests\Frontend\User\Support\ShowSupportTicketRequest;
use App\Http\Requests\Frontend\User\Support\StoreSupportRequest;
use App\Http\Traits\UploadHandler;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class UserSupportController extends Controller
{
    //
    use UploadHandler;
    public function index()
    {
        $tickets = SupportTicket::where('member_id', auth()->id())->where('parent_id', null)->latest()->get();
        return view("frontend.user.support.index", compact("tickets"));
    }

    public function create()
    {
        return view("frontend.user.support.create");
    }

    public function store(StoreSupportRequest $request)
    {
        $support = new SupportTicket;
        $support->member_id = auth()->id();
        $support->category = $request->category;
        $support->title = $request->title;
        $support->priority = $request->priority;
        $support->status = "pending";
        $support->issue = $request->message;
        if ($request->hasFile("media")) {
            $this->set_upload_path("website/support");
            $support->media = $this->upload($request, "media");
        }

        try {
            $support->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to create ticket at the moment.");
            return back()->withInput();
        }

        session()->flash("success", "New Support Ticket Opened.");
        return back();
    }

    public function show(ShowSupportTicketRequest $request, SupportTicket $ticket)
    {
        $replies = SupportTicket::where('parent_id', $ticket->id)->latest()->get();
        return view("frontend.user.support.show", compact('ticket', 'replies'));
    }

    public function replyTicket(ReplySupportTicketRequest $request, SupportTicket $ticket)
    {
        $support = new SupportTicket;
        $support->parent_id = $ticket->id;
        $support->member_id = auth()->id();
        $support->category = $ticket->category;
        $support->title = ($request->title) ? $request->title : $ticket->title;
        $support->priority = $ticket->priority;
        $support->status = "pending";
        $support->issue = $request->message;
        if ($request->hasFile("media")) {
            $this->set_upload_path("website/support");
            $support->media = $this->upload($request, "media");
        }

        try {
            $support->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to reply. ");
            return back()->withInput();
        }

        session()->flash("success", "Replied To Ticket.");
        return back();
    }

    public function closeTicket(CloseSupportTicketRequest $request, SupportTicket $ticket)
    {
        $ticket->status = "completed";
        try {
            $ticket->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to close ticket.");
            return back();
        }

        session()->flash("success", "Thank-you, Your Ticket has been closed.");
        return back();
    }
}
