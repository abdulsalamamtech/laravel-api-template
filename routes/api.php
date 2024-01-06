<?php

use App\Models\User;
use GuzzleHttp\Client;
use App\Libraries\ImageKit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware(['auth:sanctum', ''])->group(function () {
//     Route::controller(UserController::class)->group(function () {
//         Route::get('/users/{id}', 'show');
//         Route::post('/users', 'store');
//     });
//     Route::get('/', function () {
//         return User::all();
//     });
// });



Route::prefix('posts')->group( function() {

    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::post('/', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});


Route::prefix('users')->group( function() {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


// Route::prefix('uploads')->group( function() {
//     Route::get('/', [UploadController::class, 'index'])->name('uploads.index');
//     Route::post('/', [UploadController::class, 'store'])->name('uploads.store');
//     Route::post('/kit', [UploadController::class, 'kit'])->name('uploads.kit');
//     Route::get('/{upload}', [UploadController::class, 'show'])->name('uploads.show');
//     Route::put('/{upload}', [UploadController::class, 'update'])->name('uploads.update');
//     Route::delete('/{upload}', [UploadController::class, 'destroy'])->name('uploads.destroy');
// });


// upload file
Route::post('/uploads', [UploadController::class, 'upload']);




// Fallback Route
// It should always be at the end of the routes
Route::fallback(function(){
    return response()->json([
        'success' => 'false',
        'message' => 'Page Not Found. If error persists, contact abdulsalamamtech@gmail.com.com'
    ], 404);
});
