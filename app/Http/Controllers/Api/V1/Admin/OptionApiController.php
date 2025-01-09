<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionApiController extends Controller
{
    public function getOption(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ]);

        $option = Option::where('key', $request->key)->first();

        return response()->json([
            'success' => true,
            'option' => $option,
        ]);
    }

    public function addEditOption(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => '',
            'data' => '',
        ]);

        Option::updateOrCreate([
            'key' => $request->key,
        ], [
            'value' => $request->value ?? "",
            'data' => json_encode($request->data) ?? null,
            'status' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Option added successfully'
        ]);
    }

    public function deleteOption(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $option = Option::find($request->id);

        $option->delete();

        return response()->json([
            'success' => true,
            'message' => 'Option deleted successfully'
        ]);
    }
}
