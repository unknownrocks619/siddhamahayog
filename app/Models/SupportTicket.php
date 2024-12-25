<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\SupportTicket
 *
 * @property int $id
 * @property int $member_id
 * @property int|null $parent_id
 * @property string $category
 * @property string $title
 * @property string $priority
 * @property string $status Available Options: pending, Completed, Rejected, Waiting Response, Replied
 * @property string|null $issue
 * @property object|null $media
 * @property int|null $total_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $replied_by
 * @property-read \App\Models\Member|null $staff
 * @property-read \App\Models\Member $user
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereRepliedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket withoutTrashed()
 * @mixin \Eloquent
 */
class SupportTicket extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $casts = [
        "media" => "object"
    ];

    CONST ACCESS =[
        Rule::ADMIN,
        Rule::SUPER_ADMIN,
        Rule::SUPPORT
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
        $sql .= " AND parent.parent_id IS NULL";
        $sql .= " AND child.deleted_at IS NULL ";
        $sql .= " AND parent.deleted_at IS NULL ";

        return DB::select($sql)[0]->total_new_ticket;
    }

    public static function totalOpenTicket() {
        $sql = " SELECT count(parent.id) as total_pending_ticket ";
        $sql .= " FROM support_tickets parent ";
        $sql .= " WHERE (parent.status = 'pending' ";
        $sql .= " OR parent.status = 'waiting_response') AND parent.parent_id IS NULL";
        $sql .= " AND parent.deleted_at IS NULL ";

        return DB::select($sql)[0]->total_pending_ticket;
    }

    public static function totalClosedTicket() {
        $sql = " SELECT count(parent.id) as total_closed_ticket ";
        $sql .= " FROM support_tickets parent ";
        $sql .= " WHERE (parent.status = 'completed' AND parent.parent_id IS NULL)";
        $sql .= " AND parent.deleted_at IS NULL ";

        return DB::select($sql)[0]->total_closed_ticket;
    }

    public function totalHighPriorityTicket(){
    }

    public function totalWaitingReport() {

    }
}
