<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\MemberNotification;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportStaffController extends Controller
{
    //

    public function index()
    {
        $ticket_query = SupportTicket::with(["user"])->where('parent_id', null);
        if (request()->status) {
            $ticket_query->where('status', request()->status);
        }

        if (request()->category && request()->category != "finance") {
            $ticket_query->where('category', request()->category);
        }

        if (!request()->status && !request()->category) {
            $ticket_query->where('status', "!=", 'completed');
        }
        $all_tickets = $ticket_query->orderBy("updated_at", "DESC")->get();
        return view('frontend.support-staff.index', compact("all_tickets"));
    }

    public function show(SupportTicket $ticket)
    {
        $replies = SupportTicket::with(["staff"])->where('parent_id', $ticket->id)->latest()->get();
        return view('frontend.support-staff.show', compact('ticket', 'replies'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $ticket_reply = new SupportTicket;
        $ticket_reply->title = $ticket->title;
        $ticket_reply->status = "waiting_response";
        $ticket_reply->category = $ticket->category;
        $ticket_reply->priority = $ticket->priority;
        $ticket_reply->issue = $request->message;
        $ticket_reply->parent_id = $ticket->id;
        $ticket_reply->total_count = 0;
        $ticket_reply->replied_by = auth()->id();
        $ticket_reply->member_id = $ticket->member_id;

        try {
            DB::transaction(function () use ($ticket_reply, $ticket) {
                $ticket_reply->save();
                $ticket->status = "waiting_response";
                $ticket_reply->save();
                $ticket->total_count = $ticket->total_count + 1;
                $ticket->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", $th->getMessage());
            return back()->withInput();
        }

        MemberNotification::create([
            "member_id" => $ticket->member_id,
            "title" => "Support Ticket : #" . $ticket->id,
            "body" => $request->message,
            "notification_type" => "\App\Models\SupporTicket",
            "notification_id" => $ticket->id,
            "type" => "message",
            "level" => "info",
            "seen" => false
        ]);
        session()->flash('success', "Ticket Replied.");
        return redirect()->route('supports.staff.tickets.index');
    }

    public function destroy(Request $request, SupportTicket $ticket)
    {
        try {
            //code...
            DB::transaction(function () use ($ticket, $request) {
                $ticket_response = null;
                if ($request->message) {
                    $new_ticket = new SupportTicket();
                    $new_ticket->title = $ticket->title;
                    $new_ticket->issue = $request->message;
                    $new_ticket->priority = $ticket->priority;
                    $new_ticket->parent_id = $ticket->id;
                    $new_ticket->category = $ticket->category;
                    $new_ticket->status = "completed";
                    $new_ticket->total_count = 0;
                    $new_ticket->replied_by = auth()->id();
                    $new_ticket->member_id = $ticket->member_id;
                    $new_ticket->save();
                }
                if ($ticket_response) {
                    $ticket->total_count = $ticket->total_count + 1;
                }
                $ticket->status = "completed";
                $ticket->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', $th->getMessage());
            return back()->withInput();
        }
        MemberNotification::create([
            "member_id" => $ticket->member_id,
            "title" => "Support Ticket : #" . $ticket->id,
            "body" => "Your ticket was closed.",
            "notification_type" => "\App\Models\SupporTicket",
            "notification_id" => $ticket->id,
            "type" => "message",
            "level" => "info",
            "seen" => false
        ]);
        session()->flash('success', "Ticket Closed.");
        return redirect()->route('supports.staff.tickets.index');
    }
}
