<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Controller;
use App\Models\MemberNotification;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller
{
    //
    public function index()
    {
        $tickets = SupportTicket::with("user")->where('parent_id', NULL)->where('status', '!=', 'completed')->get();
        return view("admin.supports.list", compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        return view("admin.supports.reply", compact('ticket'));
    }

    public function responseTicket(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            "title" => "required",
            "issue" => "required"
        ]);

        $supportTicket = new SupportTicket;
        $supportTicket->title = $request->title;
        $supportTicket->issue = $request->issue;
        $supportTicket->parent_id = $ticket->id;
        $supportTicket->category = $ticket->category;
        $supportTicket->status = "pending";
        $supportTicket->member_id = $ticket->member_id;
        $supportTicket->priority = $ticket->priority;

        $ticket->total_count = $ticket->total_count + 1;
        $ticket->status = "waiting_response";

        try {
            DB::transaction(function () use ($supportTicket, $ticket) {
                $ticket->save();
                $supportTicket->save();
            });
        } catch (\Throwable $th) {
            $this->json(false,'Error: '. $th->getMessage());
        }
        MemberNotification::create([
            "member_id" => $ticket->member_id,
            "title" => "Support Ticket : #" . $ticket->id,
            "body" => $request->issue,
            "notification_type" => "\App\Models\SupporTicket",
            "notification_id" => $ticket->id,
            "type" => "message",
            "level" => "info",
            "seen" => false
        ]);
        return $this->json(true,'You Replied to ticker','reload');
    }

    public function closeTicket(SupportTicket $ticket)
    {
        $ticket->status = "completed";

        try {
            $ticket->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Error: '. $th->getMessage(),'reload');
            //throw $th;
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

        return $this->returnResponse(true,'Ticket Closed.','reload');
    }

    public function editTicket()
    {
    }

    public function updateTicket()
    {
    }
}
