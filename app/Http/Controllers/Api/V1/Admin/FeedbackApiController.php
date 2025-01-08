<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackApiController extends Controller
{
    public function addFeedback(Request $request)
    {
        $request->validate([
            "feedback" => "required",
        ]);

        $data = [
            "feedback" => $request->feedback,
            "app_version" => $request->app_version ?? "",
            "user_id" => auth()->id(),
        ];

        Feedback::create($data);

        return response()->json([
            "success" => true,
            "message" => "Feedback added successfully."
        ]);
    }
}
