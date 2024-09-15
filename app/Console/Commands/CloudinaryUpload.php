<?php

namespace App\Console\Commands;

use App\Classes\Helpers\Image;
use App\Models\ImageRelation;
use App\Models\Images;
use Cloudinary\Cloudinary;
use Illuminate\Console\Command;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Storage;

class CloudinaryUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudinary:upload {--date=} {--order=} {--limit=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Existing file to cloudinary';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // connect with cloudinary account.
        $imagesQuery = Images::where('bucket_type','local')->join('image_relations',function(JoinClause $join) {
                            $join->on('images.id','=','image_id');
                        });
        if ($this->option('order')) {
            $imagesQuery->orderBy('images.id',$this->option('order'));
        }
        if ($this->option('limit') ) {
            $imagesQuery->limit($this->option('limit'));
        }

        if ($this->option('date') ) {
            $imagesQuery->where('filepath','LIKE','%'.$this->option('date').'%');
        }

        $images = $imagesQuery->get();

        foreach ($images as $image) {
            /** @var Images $image */
            $filepath = $image->getRawOriginal('filepath');
            if ( !  Storage::disk('local')->exists('uploads/org/'.$filepath) ) {
                echo 'Skipping ' . $filepath . PHP_EOL;
                continue;
            }
            $signed = false;

            if (in_array(strtolower($image->type), ImageRelation::PROTECTED_IMAGES) ) {
                $signed = true;
            }
            $assetFolder = explode('/',$filepath);
            $cloudinaryAssetFolder = date("Y/m");
            $publicID = $filepath;

            if (count($assetFolder) > 1) {
                $publicID = $assetFolder[count($assetFolder)-1];
                $cloudinaryAssetFolder = $assetFolder[0].'/'.$assetFolder['1'];
            }

            $cloudinary = new Cloudinary();
            $uploadResponse = $cloudinary->uploadApi()
                ->upload(Storage::disk('local')->path('uploads/org/'.$filepath),
                    [
                        'use_asset_folder_as_public_id_prefix'  => true,
                        'asset_folder' => $cloudinaryAssetFolder,
                        'public_id' => pathinfo($publicID,PATHINFO_FILENAME),
                        'display_name'  => $image->original_filename,
                        'faces' => true,
                        'access_mode'   => $signed == true ? 'public' : 'authenticated'
                    ]
                );

            $image->fill([
               'public_id'  => $uploadResponse['public_id'],
               'upload_revision'    => $uploadResponse['version_id'],
               'bucket_upload_response' => $uploadResponse,
               'bucket_filename'   => $uploadResponse['display_name'].'.'.$uploadResponse['format'],
               'bucket_signature'   => $uploadResponse['signature'],
               'bucket_type' => 'cloudinary',
            ]);
            $image->save();
            echo 'File Uploaded. Sleeping..'. PHP_EOL;
        }

//        dd($uploadResponse->getArrayCopy());
        return Command::SUCCESS;
    }


}
