<?php
use App\Http\Controllers\Frontend\Events\EventController;

//use App\Http\Controllers\Frontend\Frontend\EventController;
use App\Http\Controllers\Frontend\Sadhana\SadhanaController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Payment\EsewaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('vedanta.index');
    // return view('index');
});

Route::prefix('esewa')->name("esewa.")
    ->controller(SadhanaController::class)
    ->group(function () {
        Route::get('/payment-success', "local_payment_success")->name("payment.success");
        Route::get('/payment-failure', "payment_error")->name("payment.failure");
    });




Route::get('/user/dashboard', [ProfileController::class, "index"])->middleware(['auth'])->name('dashboard');

Route::get("/terms", function () {
    return view("terms");
})->name('terms');
require __DIR__ . '/auth.php';
require __DIR__ . "/admin.php";
require __DIR__ . "/widgets/index.php";
// Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix("event")->name("events.")
    ->group(function () {
        Route::get('{slug}', [EventController::class, "event"])->name("event_detail");
    });



Route::prefix("sadhana")->name('sadhana.')
    ->middleware(["auth"])
    ->group(function () {

        Route::get('/mahayog-sadhana', function () {
            return redirect()->route('vedanta.index');
        })->name('detail');
        // Route::get("/mahayog-sadhana", [SadhanaController::class, "index"])->name('detail');
        Route::get("/signup", [SadhanaController::class, "create"])->name("create");
        Route::get("/signup/history", [SadhanaController::class, "createHistory"])->name("create.history");
        Route::get("/signup/complete", [SadhanaController::class, "SadhanaEnrollComplete"])->name("process.complete");
        Route::post("/payment/process", [SadhanaController::class, "payment_process"])->name('sadhana_payment_process');
        Route::post('payment/complete', [SadhanaController::class, "complete_payment"])->name("sadhana_payment_complete");
        Route::post('/payment/local/{type}', [SadhanaController::class, "local_payment_process"])->name('sadhana_local_payment_process');
        Route::post('/signup-sadhana', [SadhanaController::class, "store"])->name('sadhana-store');
        Route::post('/signup/history', [SadhanaController::class, "storeHistory"])->name('store.history');
    });

require __DIR__ . "/frontend/web.php";
require __DIR__ . "/frontend/sadhana.php";
