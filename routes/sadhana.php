<?php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\PartialController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\SadhanaController;


        Route::get("/user-register",[UserController::class,"sadhana_registration_form"])
                ->name('sadhana-registration-one');
        
        Route::get('/request-call/{type}/{partials}',[PartialController::class,"get_partials"])
                ->name('sadhana-registar-type-selection');
        
        Route::post("/register-user",[SadhanaController::class,"first_user_draft"])
                ->name('post-sadhana-registration-one');

        Route::get('/register-user/continue/{user}',[SadhanaController::class,"second_user_draft"])
                ->name('sadhana-step-two');

        Route::post('/submit-application/{user}',[SadhanaController::class,"submit_user_application"])
                ->name('sadhana-application-submission');

        Route::get('/application-complet/{user}',[SadhanaController::class,'complete_application'])
                ->name('application-complete');
        
        Route::post('/validate-existing-user',[SadhanaController::class,'existing_user_verify'])
                ->name('verify-existing-email');

        Route::get('/user-registraion-exist/{user}',[SadhanaController::class,"exisiting_user_second_step"])
                ->name('user-registraion-exist');

        Route::post('/old-sadhak-entry-record/{user}',[SadhanaController::class,"enquries"])
                ->name('sadhak-entry-record');
        
        Route::post('destroy/{user}/{action}',[SadhanaController::class,'destroy_current_application'])
                ->name('destroy-application')
?>