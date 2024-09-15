<?php

namespace App\Classes\Helpers;
use App\Models\ImageRelation as FileRelation;
use App\Models\Images;
use App\Models\Images as ModelsImage;
use Cloudinary\Cloudinary;
use Cloudinary\Tag\ImageTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Nette\Utils\ImageException;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Image
{

    /**
     * @param mixed $images
     * @param Model|null $model
     * @param array $additionalRequest
     * @return bool|array
     */
    public static function uploadImage(mixed $images, Model $model = null, array $additionalRequest = []): bool|array
    {

        $settings = config('image-settings');
        $records = [];
        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {

            $generatedFilename = $image->hashName();
            $uploadAPI = new Cloudinary();
            $folder = date('Y/m');
            try {
                $apiResponse = $uploadAPI->uploadApi()->upload($image->getRealPath(),[
                    'use_asset_folder_as_public_id_prefix'  => true,
                    'asset_folder' => $folder,
                    'display_name'  => $image->getClientOriginalName(),
                    'faces' => true,
                    'filename' => $image->getClientOriginalName(),
                ])->getArrayCopy();

                $newImage = new ModelsImage();
                $newImage->fill([
                    'filename' => pathinfo($apiResponse['url'],PATHINFO_FILENAME).'.'.$apiResponse['format'],
                    'filepath' => $apiResponse['public_id'],
                    'information' => [
                        'exif' => [],
                        'folders' => date('Y') . '/' . date("m")
                    ],
                    'sizes' => [
                        'width' => $apiResponse['width'] ?? 0,
                        'height' => $apiResponse['height'] ?? 0,
                    ],
                    'original_filename' => $image->getClientOriginalName(),
                    'bucket_type' => Images::BUCKET_CLOUDINARY,
                    'bucket_upload_response' => $apiResponse,
                    'public_id' => $apiResponse['public_id'],
                    'upload_revision' => $apiResponse['version_id'],
                    'bucket_filename' => pathinfo($apiResponse['url'],PATHINFO_FILENAME).'.'.$apiResponse['format'],
                    'bucket_filepath'   => $apiResponse['public_id'],
                    'bucket_signature'  => $apiResponse['signature'],
                ]);

                if (!$newImage->save()) {
                    return false;
                }

            } catch ( \Exception $e) {
                $newImage = (new Image())->fallbackDefaultUpload($image);

                if ( ! $newImage ) {
                    return false;
                }
            }

            if (!is_null($model)) {
                $fileRelation = new FileRelation();
                $fileRelation->fill([
                    'image_id' => $newImage->getKey(),
                    'relation' => $model::class,
                    'relation_id' => $model->getKey()
                ]);

                if (!$fileRelation->save()) {
                    return false;
                }
            }

            $records[] = ['image' => $newImage, 'relation' => $fileRelation];
        }

        return $records;
    }


    /**
     * @param mixed $images
     * @return bool|array
     */
    public static function uploadOnly(mixed $images): bool|array
    {
        $settings = config('image-settings');
        $records = [];
        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {

            $folder = date("Y/m");
            $uploadAPI = new Cloudinary();

            try {
                $apiResponse = $uploadAPI->uploadApi()->upload($image->getRealPath(),[
                    'use_asset_folder_as_public_id_prefix'  => true,
                    'asset_folder' => $folder,
                    'display_name'  => $image->getClientOriginalName(),
                    'faces' => true,
                    'filename' => $image->getClientOriginalName(),
                ])->getArrayCopy();

            } catch (\Exception $exception) {
                $newImage = (new self)->fallbackDefaultUpload($image);

                if ( !$newImage ) {
                    return false;
                }
            }

            $records[] = $newImage;
        }

        return $records;
    }

    public static function getImageAsSize($filePath, $size = 'm')
    {
        if ( $filePath instanceof \Cloudinary\Asset\Image) {
            return $filePath->toUrl();
        }

        if (gettype($filePath) == 'object') {
            $filePath = $filePath->filepath;
        }

        $domainPath = env('APP_URL');
        $sotragePath = asset('uploads/' . $size . '/' . $filePath, false);
        return $sotragePath;
    }

    public static function pdfToImage(string $filepath): array
    {
        $result = [];
        if (!file_exists(Storage::disk('local')->exists($filepath))) {
            return $result;
        }

        return $result;
    }

    public static function urlToImage(string $url,$originalSource = 'dharmasala-processing') {

        $originalFilename = pathinfo($url, PATHINFO_FILENAME);
        $generatedFilename = Str::random(40);
        $fileExtension = pathinfo($url,PATHINFO_EXTENSION);
        $sizes = config('image-settings')['sizes'];
        $originalFileSource = $originalSource.'/'.$originalFilename.'.'.$fileExtension;
        $baseOriginal = 'uploads/org/'.date('Y').'/'.date('m');
        Storage::disk('local')->copy($originalFileSource,$baseOriginal.'/'.$generatedFilename.'.'.$fileExtension);

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
        return $image;
    }

    /**
     * @param $imagePath
     * @param $position
     * @param $offset_x
     * @param $offset_y
     * @param $width
     * @param $height
     * @return void
     */
    public static function insertImage($imagePath,$position,$offset_x, $offset_y,$width, $height) {
        $manager =  ImageManager::make($imagePath);
    }

    /**
     * @param string $imagePath
     * @param float|int $width
     * @param float|int $height
     * @return string
     */
    public static function resizeImage(string $imagePath , float|int $width, float|int $height) {
        $imageManager = ImageManager::make($imagePath);
        $imageManager->resize($width,$height, function($constraint){
//            $constraint->aspectRatio();
            // $constraint->upsize();
        });
        $generatedFilename = Str::random(20);

        $fileExtension = pathinfo(self::getImageAsSize($imagePath),PATHINFO_EXTENSION);
        Storage::disk('local')->put('uploads/resized/' . $generatedFilename.'.'.$fileExtension, $imageManager->encode('jpg',100)->__toString());

        return $generatedFilename.'.'.$fileExtension;
    }


    /**
     * Generate Barcode Generator
     * @param string $text
     * @param int $width
     * @param int $height
     */

    public static function generateBarcode(string $text, int $width, int $height) {
        $barcodeGenerator = new BarcodeGeneratorJPG();
        $orientation = ($width > $height) ? 'horizontal' : 'vertical';
        $barcodeImage = $barcodeGenerator->getBarcode($text,$barcodeGenerator::TYPE_CODE_128,1,$height);

        $generatedFilename = Str::random(20);
        Storage::disk('local')->put("uploads/barcode/{$text}_".$generatedFilename.'.png',$barcodeImage);

        $filename=  "{$text}_".$generatedFilename.'.png';
        // InterventionImageHelper::horizontalOrientation(asset($filename),$filename);
//        InterventionImageHelper::resize(Image::getImageAsSize($filename,'barcode'),$width,$height,$filename);

        return $filename;
    }

    public static function dynamicBarCode(string $text) {
        $htmlGenerator = new BarcodeGeneratorHTML();
        return $htmlGenerator->getBarcode($text,$htmlGenerator::TYPE_CODE_128);
    }

    /**
     * @param UploadedFile $file
     * @return ModelsImage|null
     */
    public function fallbackDefaultUpload(UploadedFile $file): Images|null {
        $generatedFilename = $file->hashName();
        $settings = config('image-settings');

        list($width, $height) = getimagesize($file->getRealPath());

        foreach ($settings['sizes'] as $folder => $option) {

            $resizeImage = ImageManager::make($file->getRealPath());
            $resizeImage->resize($option['height'], $option['width'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $resizeImage->encode();
            $baseDir = 'uploads/' . $folder . '/' . date("Y") . '/' . date('m');

            Storage::put($baseDir . '/' . $generatedFilename, $resizeImage->__toString());
        }

        $file->store('uploads/org/' . date('Y') . '/' . date('m'));
        $exif = ImageManager::make($file->getRealPath())->exif();
        $newImage = new ModelsImage();
        $newImage->fill([
            'filename' => $generatedFilename,
            'filepath' => date('Y') . '/' . date("m") . '/' . $generatedFilename,
            'information' => [
                'exif' => $exif,
                'folders' => date('Y') . '/' . date("m")
            ],
            'sizes' => [
                'width' => $width ?? 0,
                'height' => $height ?? 0,
            ],
            'original_filename' => $file->getClientOriginalName(),
            'bucket_type' => 'local'
        ]);

        if (!$newImage->save()) {
            return null;
        }

        return $newImage;
    }
}
