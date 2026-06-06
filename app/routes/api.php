<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HelpRequestController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

// Publiek
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/help-request-categories', [HelpRequestController::class, 'categories']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Gebruikers
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::post('users/{user}/photo', [UserController::class, 'uploadPhoto']);
    Route::middleware('advisor')->group(function () {
        Route::patch('users/{user}/verify', [UserController::class, 'verify']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
    });

    // Dienstvragers
    Route::apiResource('clients', ClientController::class)->only(['index', 'show', 'update']);

    // Vrijwilligers
    Route::apiResource('volunteers', VolunteerController::class)->only(['index', 'show', 'update']);
    Route::get('volunteers/{volunteer}/reviews', [VolunteerController::class, 'reviews']);
    Route::middleware('volunteer')->group(function () {
        Route::post('volunteers/{volunteer}/availabilities', [VolunteerController::class, 'addAvailability']);
        Route::put('volunteers/{volunteer}/categories', [VolunteerController::class, 'syncCategories']);
    });
    Route::delete('volunteers/{volunteer}/availabilities/{availabilityId}', [VolunteerController::class, 'deleteAvailability']);
    Route::middleware('client')->group(function () {
        Route::post('volunteers/{volunteer}/favorite', [VolunteerController::class, 'favorite']);
        Route::delete('volunteers/{volunteer}/favorite', [VolunteerController::class, 'unfavorite']);
    });

    // Intakes
    Route::middleware('advisor')->group(function () {
        Route::get('intakes', [IntakeController::class, 'index']);
        Route::get('intakes/{intake}', [IntakeController::class, 'show']);
        Route::put('intakes/{intake}', [IntakeController::class, 'update']);
    });

    // Hulpvragen
    Route::middleware('subscription')->group(function () {
        Route::apiResource('help-requests', HelpRequestController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::patch('help-requests/{helpRequest}', [HelpRequestController::class, 'update']);
        Route::middleware('volunteer')->group(function () {
            Route::post('help-requests/{helpRequest}/accept', [HelpRequestController::class, 'accept']);
        });
    });

    // Afspraken
    Route::middleware('subscription')->group(function () {
        Route::apiResource('appointments', AppointmentController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::patch('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm']);
    });

    // Abonnementen
    Route::get('subscriptions', [SubscriptionController::class, 'index']);
    Route::middleware('advisor')->group(function () {
        Route::post('subscriptions', [SubscriptionController::class, 'store']);
        Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update']);
        Route::patch('subscriptions/{subscription}/pay', [SubscriptionController::class, 'pay']);
        Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy']);
    });
});
