<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageVisitController;

Route::post('/page-visit', [PageVisitController::class, 'store']);
Route::get('/top-pages', [PageVisitController::class, 'topPages']);
Route::get('/page-visit', [PageVisitController::class, 'getCount']);
