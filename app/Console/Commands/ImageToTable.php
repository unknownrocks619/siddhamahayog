<?php

namespace App\Console\Commands;

use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImageToTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert profile string based image to different table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allMembers = Member::select(['id','profile','profileUrl'])
                        ->get();

        if ( ! Storage::disk('local')->exists('uploads/org') ) {
            Storage::disk('local')->makeDirectory('uploads/org',0755);
        }

        $imageConfig =config('image-settings');

        foreach ($imageConfig['sizes'] as $folderName => $config) {

            if ( ! Storage::disk('local')->exists('uploads/'.$folderName) ) {
                Storage::disk('local')->makeDirectory('uploads/'.$folderName);
            }
        }

        foreach ($allMembers as $member) {

            if ( ! $member->profile && ! $member->profileUrl) {
                echo 'Skipping for empty column.' . PHP_EOL;
                continue;
            }

            if ($member->profile) {

                echo 'Processing : ' . $member->getKey() . PHP_EOL;
                // check using full_path
                if (isset ($member->profile->full_path) ) {
                    $url = str_replace('uploads/m','uploads/cus', $member->profile->full_path);
                    $originalFilename = pathinfo($url,PATHINFO_FILENAME);
                    $this->downloadAndSaveImage($url,$member,$originalFilename,'profile_picture');
                }
//
                if (isset($member->profile->id_card) ) {
                    $url = str_replace('uploads/m','uploads/cus', $member->profile->id_card);
                    $originalFilename = pathinfo($url,PATHINFO_FILENAME);
                    $this->downloadAndSaveImage($url,$member,$originalFilename,'id_card');
                }

                // Check using path
                if ( isset($member->profile->path) ) {
                    $originalFilename = $member->profile->original_filename;
                    $url = asset($member->profile->path);
                    $this->downloadAndSaveImage($url,$member,$originalFilename,'profile_picture');
                }

            }

        }

    }

    public function downloadAndSaveImage(string $url, Member $member, $originalFilename,$type) {

        if ( ! $this->url_exists($url) ) {
            echo 'Skipping URL ' . $url .' File Does not exists.' . PHP_EOL;
            return;
        }

        $generatedFilename = Str::random(40);
        $fileExtension = pathinfo($url,PATHINFO_EXTENSION);
        $sizes = config('image-settings')['sizes'];
        $imageContent = file_get_contents($url);
        $baseOriginal = 'uploads/org/'.date('Y').'/'.date('m');
        Storage::disk('local')->put($baseOriginal.'/'.$generatedFilename.'.'.$fileExtension,$imageContent);

        foreach ($sizes as $sizeName => $sizeConfig) {
            $resizeImage = \Intervention\Image\ImageManagerStatic::make(Storage::disk('local')->get($baseOriginal.'/'.$generatedFilename.'.'.$fileExtension));
            $resizeImage->resize($sizeConfig['width'], $sizeConfig['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $resizeImage->encode();
            $baseDir = 'uploads/' . $sizeName . '/' . date("Y") . '/' . date('m');
            Storage::disk('local')->put($baseDir . '/' . $generatedFilename.'.'.$fileExtension, $resizeImage->__toString());
        }

        $image = new Images();
        $image->fill([
            'filename'  => $generatedFilename,
            'original_filename' => $originalFilename,
            'filepath'  => date("Y").'/'.date('m').'/'.$generatedFilename.'.'.$fileExtension,
            'sizes' => [],
            'access_type'   => 'path'
        ]);

        $image->save();

        //
        $imageRelation = new ImageRelation();
        $imageRelation->fill([
            'image_id'  => $image->getKey(),
            'relation'  => $member::class,
            'relation_id'   => $member->getKey(),
            'type'  => $type,
        ]);

        $imageRelation->save();

    }


// Function to check if a URL exists
    function url_exists($url)
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }
}
