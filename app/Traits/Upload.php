<?php

namespace App\Traits;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Uploader;
/**
 * 
 */
trait Upload
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request,$file_name = null)
    {   
        //
        if ( ! $file_name ) {
            
            // let's upload and set in the given location
            $uploader = new Uploader();

            // orginal filename 
            $uploader->original_name = $request->file('file')->getOrginalClientName();
            $uploader->file_type = $request->file('file')->getFileType();
            $uploader->path =  Storage::putFile('site',$request->file('file')->path());
            return $uploader->save();
        }
        if ($request->hasFile($file_name)) {
            // let's upload and set in the given location
            $uploader = new Uploader();
            $file_detail = [
                "original_name" =>$request->file($file_name)->getClientOriginalName (),
                'file_type' => $request->file($file_name)->getMimeType(),
                'path' =>Storage::putFile('site',$request->file($file_name)->path())
            ];
            // orginal filename 
        
            return $uploader->create($file_detail);
        }
    }

   
}
