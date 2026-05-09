<?php

use App\Http\Controllers\Api\MidtransCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'midtransCallback']);
