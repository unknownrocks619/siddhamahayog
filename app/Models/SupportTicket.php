<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SupportTicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "media" => "object"
    ];

    public function user()
    {
        return $this->belongsTo(Member::class, "member_id");
    }

    public function staff()
    {
        return $this->belongsTo(Member::class, "replied_by");
    }

    public static function totalNewTicket() {
        $sql = " SELECT count(parent.id) as total_new_ticket ";
        $sql .= " FROM support_tickets parent ";
        $sql .= " LEFT JOIN support_tickets child";
        $sql .= " ON child.parent_id = parent.id ";
        $sql .= " WHERE child.id IS NULL ";
        $sql .= " AND child.deleted_at IS NULL ";
        $sql .= " AND parent.deleted_at IS NULL ";

        return DB::select($sql)[0]->total_new_ticket;
    }

    public static function totalOpenTicket() {
        $sql = " SELECT count(parent.id) as total_pending_ticket ";
        $sql .= " FROM support_tickets parent ";
        $sql .= " WHERE (parent.status = 'pending' ";
        $sql .= " OR parent.status = 'waiting_response' )";
        $sql .= " AND parent.deleted_at IS NULL ";

        return DB::select($sql)[0]->total_pending_ticket;
    }

    public function totalHighPriorityTicket(){
    }

    public function totalWaitingReport() {

    }
}
