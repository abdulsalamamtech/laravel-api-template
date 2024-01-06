<?php

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
    return ['Laravel' => app()->version()];
});

Route::get('/artisan/{code}', function ($code) {
    if($code == 'optimize'){
        Artisan::call('optimize:clear');
        return ['Laravel Index' => 'successfull ' . $code];
    }elseif($code == 'migrate'){
        Artisan::call('migrate');
        return ['Laravel Index' => 'successfull ' . $code];
    }else{
        
        return ['Laravel Index' => 'Nothing to do! ' . $code];
    }
});

// require __DIR__.'/auth.php';
