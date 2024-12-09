<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getOtp()
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
