<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function TestFunc()
    {
        return response()->json([
            'message' => 'Test function is working!'
        ]);
    }
}
