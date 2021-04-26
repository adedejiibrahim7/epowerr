<?php
//
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\GistController;

///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register API routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| is assigned the "api" middleware group. Enjoy building your API!
//|
//*/
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => '/v1/'], function(){
    Route::post('/auth/login', [JwtAuthController::class, 'login'])->name('login');
    Route::post('/auth/register', [JwtAuthController::class, 'register']);

    Route::group(['middleware' => 'auth:jwt'], function () {

        Route::get('logout', [JwtAuthController::class, 'logout']);
        Route::get('/auth/user', [JwtAuthController::class, 'getUser']);

        Route::get('/gists', [GistController::class, 'index'])->name('gists');
        Route::post('/gists', [GistController::class, 'create'])->name('gists.create');
        Route::get('/gists/{gist}', [GistController::class, 'show'])->name('gists.show');
        Route::patch('/gists/{gist}', [GistController::class, 'update'])->name('gists.update');
        Route::delete('/gists/{gist}', [GistController::class, 'delete'])->name('gists.delete');
    });
});
