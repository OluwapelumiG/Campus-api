<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
Route::prefix('v1')->group(function() {
    Route::apiResource('/users', UserController::class);

    Route::controller(UserController::class)->group(function(){
        Route::post('register', 'store');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('/gigs', GigController::class);
        Route::apiResource('/applications', ApplicationController::class);
        Route::get('my-gigs', [GigController::class, 'myGigs'])->name('myGigs');
        Route::get('my-applications', [ApplicationController::class, 'myApplications'])->name('myApplications');
        Route::get('my-gigs/{gig}/applications', [GigController::class, 'myGigsApplications'])->name('myGigsApplications');
//        Route::apiResource('/jobs', GigController::class);
    });
});
