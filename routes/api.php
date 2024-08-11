<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

use App\Models\User;


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::apiResource('/users', UserController::class);

    Route::controller(UserController::class)->group(function () {
        Route::post('register', 'store');
        Route::post('login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/gigs', GigController::class);
        Route::get('/user/{user}', [UserController::class, 'show']);
        Route::apiResource('/applications', ApplicationController::class);
        // Route::delete('/del-application/{id}', [ApplicationController::class, 'destroy'])->name('deleteApplication');
        Route::get('my-gigs', [GigController::class, 'myGigs'])->name('myGigs');
        Route::get('/new-gigs', [GigController::class, 'newGigApplication'])->name('newGigs');
        Route::get('my-applications', [ApplicationController::class, 'myApplications'])->name('myApplications');
        Route::get('my-gigs/{gig}/applications', [GigController::class, 'myGigsApplications'])->name('myGigsApplications');
        Route::post('my-gigs/{gig}/accept', [GigController::class, 'acceptGigApplication'])->name('acceptGigApplication');
        Route::apiResource('messages', MessageController::class);
        Route::get('/unreadmessages', [MessageController::class, 'getUnreadMessages']);
        Route::get('/conversations', [MessageController::class, 'getConversations']);
        Route::get('/readall/{sender}', [MessageController::class, 'readAllMessages']);
        Route::get('/conversations/{userId}', [MessageController::class, 'getConversationWithUser']);

        //        Route::apiResource('/jobs', GigController::class);
    });

    // Route::get('/test', function () {
    //     $receiver = User::find(5); // replace with actual user id
    //     $sender = User::find(5); // replace with actual user id
    //     $message = 'Test message';

    //     broadcast(new \App\Events\MessageSent($receiver, $sender, $message));

    //     return 'Event broadcasted';
    // });
});
