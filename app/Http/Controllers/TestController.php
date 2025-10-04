<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello, Laravel!'
        ]);
    }
}
