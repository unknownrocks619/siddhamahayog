<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ImageRelation
 *
 * @property int $id
 * @property int $image_id
 * @property string $relation
 * @property int $relation_id
 * @property string|null $type
 * @property string|null $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Images|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageRelation withoutTrashed()
 * @mixin \Eloquent
 */
class ImageRelation extends Model
{
    use HasFactory,SoftDeletes;

    const PROTECTED_IMAGES = [
        'id_card'
    ];

    const PUBLIC_IMAGES = [
        'profile_picture'
    ];

    protected  $fillable = [
        'image_id',
        'relation_id',
        'relation',
        'type',
        'title',
        'description'
    ];

    protected $with = [
        'image'
    ];

    public function image() {
        return $this->hasOne(Images::class,'id','image_id');
    }

    public function storeRelation(Model $uploadFrom , Images $image) {
        $fileRelation = new self();
        $fileRelation->fill([
            'image_id' => $image->getKey(),
            'relation' => $uploadFrom::class,
            'relation_id' => $uploadFrom->getKey()
        ]);

        $fileRelation->save();

        return $fileRelation;
    }
}
