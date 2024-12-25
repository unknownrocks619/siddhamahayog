<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ProgramGrouping
 *
 * @property int $id
 * @property int $program_id
 * @property int|null $batch_id
 * @property string $group_name
 * @property string $enable_auto_adding
 * @property int $is_scan
 * @property int $scan_type
 * @property int $group_type 1: User Pass, 2: Volunteer, 3: Guest, 4: Other
 * @property int $id_parent
 * @property string $print_primary_colour
 * @property array|null $rules
 * @property int|null $default_photo
 * @property string $actual_print_width
 * @property string $actual_print_height
 * @property int|null $id_card_sample
 * @property string|null $id_card_print_width
 * @property string|null $id_card_print_height
 * @property string|null $id_card_print_position_x
 * @property string|null $id_card_print_position_y
 * @property string|null $barcode_print_width
 * @property string|null $barcode_print_height
 * @property string|null $barcode_print_position_x
 * @property string|null $barcode_print_position_y
 * @property string|null $personal_info_print_width
 * @property string|null $personal_info_print_height
 * @property string|null $personal_info_print_position_x
 * @property string|null $personal_info_print_position_y
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $enable_barcode
 * @property int $enable_personal_info
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProgramGrouping> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramGroupPeople> $groupMember
 * @property-read int|null $group_member_count
 * @property-read \App\Models\Images|null $mediaSample
 * @property-read \App\Models\Images|null $resizedImage
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereActualPrintHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereActualPrintWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereBarcodePrintHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereBarcodePrintPositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereBarcodePrintPositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereBarcodePrintWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereDefaultPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereEnableAutoAdding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereEnableBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereEnablePersonalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereGroupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdCardPrintHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdCardPrintPositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdCardPrintPositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdCardPrintWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdCardSample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereIsScan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping wherePersonalInfoPrintHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping wherePersonalInfoPrintPositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping wherePersonalInfoPrintPositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping wherePersonalInfoPrintWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping wherePrintPrimaryColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereScanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGrouping withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramGrouping extends Model
{
    use HasFactory, SoftDeletes;

    protected $joins = [];

    protected $fillable = [
        'program_id',
        'batch_id',
        'group_name',
        'enable_auto_adding',
//         'is_scan',
//         'scan_type',
        'id_parent',
        'rules',
        'actual_print_width',
        'actual_print_height',
        'id_card_sample',
        'id_card_print_width',
        'id_card_print_height',
        'id_card_print_position_x',
        'id_card_print_position_y',
        'enable_barcode',
        'barcode_print_width',
        'barcode_print_height',
        'barcode_print_position_x',
        'barcode_print_position_y',
        'enable_personal_info',
        'personal_info_print_width',
        'personal_info_print_height',
        'personal_info_print_position_x',
        'personal_info_print_position_y',
        'print_primary_colour'
    ];

    protected $casts = [
        'rules' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    const IMAGE_TYPE = 'ID CARD';
    const IMAGE_RESIZED = 'RESIZED';

    /**
     * @param Program $program
     * @return array
     */
    public static function singleGrouping(Program $program) {
        $selects = [
            'mem.full_name',
            'mem.email',
            'mem.gotra',
            'mem.phone_number',
            'mem.gender',
            'country.name as country_name',
            'mem.address'
        ];

        $sql = " SELECT ";
        $sql .= implode(", ", $selects);
        $sql .= " FROM programs pro ";

        $sql .= "INNER JOIN program_students prostu
                    ON prostu.program_id = pro.id
                    AND prostu.deleted_at IS NULL
                    AND prostu.active = 1
                ";

        $sql .= "INNER JOIN members mem
                    ON mem.id = prostu.student_id
                    AND mem.deleted_at IS NULL
                    AND mem.role_id NOT IN (1,12,13)
                ";

        $sql .= "LEFT JOIN member_emergency_metas mem_meta
                    ON mem_meta.member_id = mem.id
                    AND mem_meta.contact_type = 'family'
                    AND mem_meta.deleted_at IS NULL
                ";

        $sql .= "LEFT JOIN countries country
                    on country.id = mem.country
                ";
        $sql .= " WHERE ";
        $sql .= 'pro.id = ?';
        $sql .= " AND ";
        $sql .= " mem_meta.contact_type IS NULL ";


        return DB::select($sql,[$program->getKey()]);

    }


    /**
     * @param Program $program
     * @return array
     */
    public static function familyGrouping(Program $program) {
        $selects = [
            'mem.full_name',
            'mem.email',
            'mem.gotra',
            'mem.phone_number',
            'mem.gender',
            'country.name as country_name',
            'mem.address',
            'GROUP_CONCAT(mem_meta.contact_person) as family_members',
            'COUNT(mem_meta.id) as total_family_member',
            'GROUP_CONCAT(mem_meta.phone_number) as family_contact_number',
            'GROUP_CONCAT(mem_meta.gender) as family_gender',
            'GROUP_CONCAT(mem_meta.relation) as family_relation'
        ];

        $sql = " SELECT ";
        $sql .= implode(", ", $selects);
        $sql .= " FROM programs pro ";

        $sql .= "INNER JOIN program_students prostu
                    ON prostu.program_id = pro.id
                    AND prostu.deleted_at IS NULL
                    AND prostu.active = 1
                ";

        $sql .= "INNER JOIN members mem
                    ON mem.id = prostu.student_id
                    AND mem.deleted_at IS NULL
                    AND mem.role_id NOT IN (1,12,13)
                ";

        $sql .= "LEFT JOIN member_emergency_metas mem_meta
                    ON mem_meta.member_id = mem.id
                    AND mem_meta.contact_type = 'family'
                    AND mem_meta.deleted_at IS NULL
                ";

        $sql .= "LEFT JOIN countries country
                    on country.id = mem.country
                ";
        $sql .= " WHERE ";
        $sql .= 'pro.id = ?';
        $sql .= " AND ";
        $sql .= " mem_meta.contact_type IS NOT NULL ";
        $sql .= " GROUP BY mem.id";

        return DB::select($sql,[$program->getKey()]);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupMember() {
        return $this->hasMany(ProgramGroupPeople::class,"group_id");
    }

    /**
     * @return HasOneThrough
     */
    public function mediaSample(): HasOneThrough {

        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id','id','image_id')
            ->where('relation',self::class)
            ->where('type',self::IMAGE_TYPE)
            ->latest();
    }

     /**
     * @return HasOneThrough
     */
    public function resizedImage(): HasOneThrough {

        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id','id','image_id')
            ->where('relation',self::class)
            ->where('type',self::IMAGE_RESIZED)
            ->orderByDesc('id');
    }

    public function children() {
        return $this->hasMany(ProgramGrouping::class,'id_parent');
    }

}
