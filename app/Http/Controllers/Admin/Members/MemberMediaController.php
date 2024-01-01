<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\ImageRelation;
use App\Models\Member;
use Illuminate\Http\Request;

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

        if (! $relation->delete() ) {
            return $this->json(false,'Unable to delete Image.');
        }

        return $this->json(true,'File Deleted.', 'reload');
    }
}
