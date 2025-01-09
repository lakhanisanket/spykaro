<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserOption;
use Illuminate\Http\Request;

class UserOptionApiController extends Controller
{
    public function getUserOptions(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ]);

        $option = UserOption::where('user_id', auth()->id())
            ->where('key', $request->key)
            ->first();

        return response()->json([
            'success' => true,
            'option' => $option,
        ]);
    }

    public function addEditUserOption(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => '',
            'data' => '',
        ]);

        $userOption = UserOption::updateOrCreate([
            'key' => $request->key,
            'user_id' => auth()->id()
        ], [
            'value' => $request->value ?? "",
            'data' => $request->data ?? ""
        ]);

        if ($request->hasFile('user_option_file')) {
            if (!$userOption->user_option_file || $request->file('user_option_file') !== $userOption->user_option_file->file_name) {
                $userOption->clearMediaCollection("user_option_file");
                $userOption->addMedia($request->file('user_option_file'))->toMediaCollection('user_option_file');
            }
        } elseif ($userOption->user_option_file) {
            $userOption->user_option_file->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'User Option added successfully'
        ]);
    }

    public function deleteUserOption(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $option = UserOption::find($request->id);

        $option->delete();

        return response()->json([
            'success' => true,
            'message' => 'User Option deleted successfully'
        ]);
    }
}
