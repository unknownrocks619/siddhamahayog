<?php

use App\Http\Controllers\Widget\AccordianWidgetController;
use App\Http\Controllers\Widget\BannerCheckmarkWidgetController;
use App\Http\Controllers\Widget\BannerImageWidgetController;
use App\Http\Controllers\Widget\BannerVideoWidgetController;
use App\Http\Controllers\Widget\ButtonWidgetController;
use App\Http\Controllers\Widget\FAQWidgetController;
use App\Http\Controllers\Widget\GalleryWidgetController;
use App\Http\Controllers\Widget\PDFWidgetController;
use App\Http\Controllers\Widget\SliderWidgetController;
use App\Http\Controllers\Widget\TextImageWidgetController;
use App\Http\Controllers\Widget\TextMapWidgetController;
use App\Http\Controllers\Widget\TextVideoWidgetController;
use App\Http\Controllers\Widget\TextWidgetController;
use Illuminate\Support\Facades\Route;


Route::prefix("widget")
    ->name('widget.')
    ->group(function () {
        Route::resource("text_map", TextMapWidgetController::class);
        Route::resource("button", ButtonWidgetController::class);
        Route::resource("accordian", AccordianWidgetController::class);
        Route::resource('faq', FAQWidgetController::class);
        Route::resource("text", TextWidgetController::class);
        Route::resource("text_video", TextVideoWidgetController::class);
        Route::resource("text_image", TextImageWidgetController::class);
        Route::resource("slider", SliderWidgetController::class);
        Route::resource("banner_video", BannerVideoWidgetController::class);
        Route::resource("banner_image", BannerImageWidgetController::class);
        Route::resource("PDF", PDFWidgetController::class);
        Route::resource("banner_checkmark", BannerCheckmarkWidgetController::class);
        Route::resource("gallery", GalleryWidgetController::class);
    });
