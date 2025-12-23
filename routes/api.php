<?php

use App\Http\Controllers\Api\PurchaseApiController;
use Illuminate\Support\Facades\Route;

Route::post('/purchases', [PurchaseApiController::class, 'store']);
