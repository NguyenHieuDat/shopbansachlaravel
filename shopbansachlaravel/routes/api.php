<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/test', function () {
    return response()->json(['message' => 'API route hoạt động tốt']);
});
