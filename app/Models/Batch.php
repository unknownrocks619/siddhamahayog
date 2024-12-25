<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Batch
 *
 * @property int $id
 * @property string $batch_name
 * @property string $slug
 * @property string|null $batch_year
 * @property string|null $batch_month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramBatch> $batch_program
 * @property-read int|null $batch_program_count
 * @method static \Illuminate\Database\Eloquent\Builder|Batch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereBatchMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereBatchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereBatchYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Batch extends Model
{
    protected $fillable = [
        'batch_name',
        'slug',
        'batch_year',
        'batch_month'
    ];

    use HasFactory;

    public function batch_program() {
        return $this->hasMany(ProgramBatch::class,"batch_id");
    }


    public function batchProgramStudent(Program $program, $searchTerm = null ) {
        $selects = [
            'prostu.id AS program_student_id',
            'prostu.roll_number',
            'prostu.active as active_student',
            'prostu.created_at as enrolled_date',
            'prostu.roll_number',
            'prostu.allow_all',
            'prostu.batch_id AS batch_id',
            'prostu.program_section_id AS section_id',
            'member.full_name',
            'member.first_name',
            'member.last_name',
            'member.phone_number',
            'member.email',
            'member.id as member_id',
            'member.country as member_country',
            'member.address',
            'memberinfo.personal as personal_detail',
            'country.name as country_name',
//            'SUM(prostufee.total_amount) as member_payment',
//            'batches.batch_name',
//            'scholar.remarks',
//            'scholar.scholar_type',
//            'scholar.id AS scholarID',
//            'section.id AS section_id'
        ];

        if ( $program->getKey() == 5 ) {
            $selects[] = 'yagya.total_counter';
        }

        $binds = [$program->getKey(),$this->getKey()];

        $sql = " SELECT ";
        $sql .= implode(', ', $selects);
        $sql .= " FROM ";
        $sql .= " program_students prostu";

        $sql .= " INNER JOIN program_batches pro_batch ";
        $sql .= " ON pro_batch.program_id = prostu.program_id ";
        $sql .= " AND pro_batch.id = prostu.batch_id ";
        $sql .= " AND pro_batch.deleted_at IS NULL ";

        $sql .= ' INNER JOIN members member ';
        $sql .= ' ON member.id = prostu.student_id ';
        $sql .= " AND member.deleted_at IS NULL ";

        $sql .= " LEFT JOIN countries country ";
        $sql .= " on member.country = country.id ";

        $sql .= " LEFT JOIN member_infos memberinfo ";
        $sql .= " ON memberinfo.member_id = member.id";

        if ( $program->getKey() == 5 ) {

            $sql .= " LEFT JOIN hanumand_yagya_counters yagya";
            $sql .= " ON yagya.member_id = member.id";
            $sql .= " AND yagya.program_id = prostu.program_id ";
        }

        $sql .= " WHERE prostu.program_id = ?";
        $sql .= ' AND pro_batch.batch_id = ?';



        if ( $searchTerm ) {
            $sql .=  " AND ( ";
            $sql .= " member.full_name LIKE ?";
            $sql .= " OR member.phone_number LIKE ?";
            $sql .= " OR member.email LIKE ? ";
            $sql .= " OR member.first_name LIKE ? ";
            $sql .= " OR member.last_name LIKE ? ";
            $sql .= " OR memberinfo.personal LIKE ?";
            $sql .= " OR country.name LIKE ? ";
            $sql .= " ) ";

            $binds= array_merge($binds, [
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
            ]);

        }

        $sql .= " GROUP BY member.id";

        return DB::select($sql, $binds);

    }
}
