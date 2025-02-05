<?php

namespace App\Classes\Helpers;

use App\Classes\Helpers\Image as HelpersImage;
use DivisionByZeroError;
use Dompdf\Adapter\GD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Gd\Font;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;

class InterventionImageHelper
{
    public static function insertImage(string $originalSource, array|string $overlayImage, int $positionX=0, int $positionY=0) {
        
        $interventionImageInstance = ImageManagerStatic::make($originalSource);
        $extension = pathinfo($originalSource,PATHINFO_EXTENSION);

        if ( ! is_array($overlayImage) ){

             $overlayImage = [
                 $overlayImage => [
                     'positionX' => $positionX,
                     'positionY'    => $positionY
                 ]
             ];

        }


        foreach ($overlayImage as $insertImage => $cordinates) {
            $interventionImageInstance->insert($insertImage,'top-left',$cordinates['positionX'],$cordinates['positionY']);
        }

        $generatedFilename = Str::random(20);
        Storage::disk('local')->put('uploads/cards/'.$generatedFilename.'.'.$extension,$interventionImageInstance->stream()->__toString());

        return $generatedFilename.'.'.$extension;
    }

    public static function horizontalOrientation($url,$savepath) {
        $interventionImage  = ImageManagerStatic::make($url);
        $interventionImage->rotate(90);
        $interventionImage->save($savepath);
    }

    public static function resize(string $fileURL, int|float $width, int|float $height, string $savePath) {
        $interventionImage = ImageManagerStatic::make($fileURL);
        $interventionImage->resize($width,$height);
        Storage::disk('local')->put('uploads/barcode/'.$savePath,$interventionImage->stream()->__toString());
//        $interventionImage->save(St$savePath);
    }

    /**
     *
     */
    public static function textToCanva(string $fileUrl = '', string|array $texts, int|float $width, int|float $height, int $positionX, int $positionY, string $textColor = '#002e5f', string $backgroundColor='#ffffff',$fallBack = false) {

        if ($fileUrl ) {
            $internVentionImage = ImageManagerStatic::make($fileUrl);
        } else {
            $internVentionImage = ImageManagerStatic::canvas($width,$height);
        }

        if ( is_string( $texts ) ) {
            $texts = [$texts];
        }

        $fontSize = 43;
        $totalLength = 0;
        $totalHeight = 0;
        foreach ($texts as $text) {
            $strlen = strlen($text);

            if ($strlen <= 10 ) {
                $strlen = 12;
            } 

            if ($strlen > $totalLength ) {
                $totalLength = $strlen;
            }
            $totalHeight++;
        }

        $fontSize =  $width / $totalLength;
        $addExtra = $height / $totalHeight;
        $startPositionX = 10;
        $startPositionY =  5;
        $canvaImage = ImageManagerStatic::canvas($width,$height,$backgroundColor);
        foreach ($texts as $text) {

            $canvaImage->text($text,$startPositionX,$startPositionY,function(Font $font)
                        use ($textColor,
                                &$startPositionX,
                                &$startPositionY,
                                $width,
                                $text,
                                $fallBack,
                                $fontSize,
                                $addExtra) {


                $font->color($textColor)
                    ->file(public_path('assets/fonts/Roboto-Bold.ttf'))
                    ->size($fontSize)
                    ->align('left')
                    ->valign('top');
                
                if (strlen($text) <= 10 ) {
                    $font->size(18);
                }

                $size = $font->getBoxSize();

                if ( $size['width']+10 <= $width ) {
                    try {
                        $font->size =  $width / strlen($text) + 5;
                    } catch (DivisionByZeroError) {

                    }

                    $size = $font->getBoxSize();
                }

                $startPositionY += $size['height'] + ($addExtra-15);


            });

        }
        $generateFilename = Str::random(30).'.png';
        $path = $generateFilename;
        Storage::disk('local')->put('uploads/text/'.$path,$canvaImage->stream()->__toString());

//         if ( $fileUrl ) {
//             $internVentionImage->insert(HelpersImage::getImageAsSize($canvaImage,'text'),'top-left',$positionX,$positionY);
//             $filepathInfo = pathinfo($fileUrl,PATHINFO_BASENAME);
//             Storage::disk('local')->put('uploads/cards/'.$filepathInfo, $internVentionImage->stream()->__toString());
// //            $internVentionImage->save('uploads/cards/'.$filepathInfo);

//         } else {
//             return $path;
//         }
        return $path;
    }




}
