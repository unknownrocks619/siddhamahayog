<?php

namespace App\Models;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Delivery;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Quality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Images
 *
 * @property int $id
 * @property string $filename
 * @property string $original_filename
 * @property string $filepath
 * @property array|null $sizes
 * @property array|null $information
 * @property string $access_type full_path,path
 * @property string $bucket_type currently available: local,cloudinary
 * @property string|null $public_id
 * @property array|null $bucket_upload_response
 * @property string|null $upload_revision
 * @property string|null $bucket_filename
 * @property string|null $bucket_filepath
 * @property string|null $bucket_signature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $file_path
 * @property-read \App\Models\ImageRelation|null $imageRelation
 * @method static \Illuminate\Database\Eloquent\Builder|Images newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Images newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Images onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Images query()
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereAccessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereBucketFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereBucketFilepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereBucketSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereBucketType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereBucketUploadResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereFilepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images wherePublicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereSizes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereUploadRevision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Images withoutTrashed()
 * @mixin \Eloquent
 */
class Images extends Model
{
    use HasFactory,SoftDeletes;

    const BUCKET_LOCAL = 'local';
    const BUCKET_CLOUDINARY = 'cloudinary';

    protected $table = 'images';

    protected $fillable = [
        'filename',
        'original_filename',
        'filepath',
        'sizes',
        'information',
        'access_type',
        'bucket_type',
        'public_id',
        'bucket_upload_response',
        'upload_revision',
        'bucket_filename',
        'bucket_filepath',
        'bucket_signature'
    ];

    protected $casts = [
        'information'   => 'array',
        'sizes' => 'array',
        'bucket_upload_response' => 'array'
    ];

    public function imageRelation() {
        return $this->hasOne(ImageRelation::class,'image_id');
    }

    public function getFilePathAttribute($value) {

        if ($this->bucket_type == self::BUCKET_CLOUDINARY) {
            $cloundinary = new Cloudinary();
            $value = $cloundinary->image($this->public_id)
                                ->delivery(Delivery::quality(Quality::auto()))
                                ->delivery(Delivery::format(Format::auto()));
//                                ->version($this->upload_revision);
        }
        return $value;

    }
}
