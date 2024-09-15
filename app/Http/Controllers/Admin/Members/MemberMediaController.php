<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberMediaController extends Controller
{

    public function uploadMedia(Request $request, Member $member) {
        $request->validate([
            'file'  => 'required',
            'file_type' => 'required|in:'.implode(',',array_keys(Member::IMAGE_TYPES))
        ]);

        $media = Image::uploadImage($request->file('file'),$member);
        if ( !isset ($media[0]) || !isset($media[0]['relation']) ) {
            return $this->json(false,'Unable to upload file.',null);
        }
        $mediaRelation = $media[0]['relation'];
        $mediaRelation->type = $request->post('file_type');
        $mediaRelation->save();

        return $this->json(true,'Upload Success.','reload');
    }

    public function deleteImage( Member $member, ImageRelation $relation){
        try {
            DB::transaction(function () use ($member, $relation) {
                if ($relation->image && $relation->image?->bucket_type == Images::BUCKET_CLOUDINARY) {
                    $cloudinary = new Cloudinary();
                    $cloudinary->adminApi()->deleteAssets($relation->image->public_id);
                    $relation->image->delete();
                }

                $relation->delete();
            });
        } catch (\Exception $e) {
            return $this->json(false,'Unable to delete Image.');

        }

        return $this->json(true,'File Deleted.', 'reload');
    }
}
