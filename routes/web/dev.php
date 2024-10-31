<?php

use Illuminate\Support\Facades\Route;

Route::get('/error/{code}', function ($code) {
    $validCodes = [401, 402, 403, 404, 419, 429, 500, 503];

    if (in_array($code, $validCodes)) {
        abort($code);
    }

    return response()->json([
        'message'     => 'not a valid error code',
        'code'        => $code,
        'valid_codes' => $validCodes,
    ], 400);
});
