<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, ItineraryController, CategoryController, DestinationController, ActivityController, DishController, ToVisitController};

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/itineraries', [ItineraryController::class, 'index']);
    Route::post('/itineraries', [ItineraryController::class, 'store']);
    Route::get('/itineraries/{itinerary}', [ItineraryController::class, 'show']);
    Route::put('/itineraries/{itinerary}', [ItineraryController::class, 'update']);
    Route::delete('/itineraries/{itinerary}', [ItineraryController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    Route::post('/itineraries/{itinerary}/destinations', [DestinationController::class, 'store']);
    Route::put('/destinations/{destination}', [DestinationController::class, 'update']);
    Route::delete('/destinations/{destination}', [DestinationController::class, 'destroy']);

    Route::post('/destinations/{destination}/activities', [ActivityController::class, 'store']);
    Route::put('/activities/{activity}', [ActivityController::class, 'update']);
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy']);

    Route::post('/destinations/{destination}/dishes', [DishController::class, 'store']);
    Route::put('/dishes/{dish}', [DishController::class, 'update']);
    Route::delete('/dishes/{dish}', [DishController::class, 'destroy']);

    Route::post('/destinations/{destination}/to-visits', [ToVisitController::class, 'store']);
    Route::put('/to-visits/{toVisit}', [ToVisitController::class, 'update']);
    Route::delete('/to-visits/{toVisit}', [ToVisitController::class, 'destroy']);

    Route::post('/itineraries/{itinerary}/save', [ItineraryController::class, 'save']);
    Route::delete('/itineraries/{itinerary}/unsave', [ItineraryController::class, 'unsave']);
    Route::get('/user/itineraries', [ItineraryController::class, 'savedItineraries']);

    Route::get('/itineraries/search', [ItineraryController::class, 'search']);
    Route::get('/itineraries/filter', [ItineraryController::class, 'filter']);
});
