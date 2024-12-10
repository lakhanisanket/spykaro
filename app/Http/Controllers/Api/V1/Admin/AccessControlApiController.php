<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessControl;
use Illuminate\Http\Request;

class AccessControlApiController extends Controller
{
    public function getAccessControl(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
        ]);

        $accessControl = AccessControl::where('user_id', auth()->id())
            ->where('device_id', $request->device_id)
            ->get();

        return response()->json([
            'success' => true,
            'access-control' => $accessControl,
        ]);
    }

    public function addAccessControl(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'name' => '',
            'type' => '',
        ]);

        AccessControl::create([
            'user_id' => auth()->id(),
            'device_id' => $request->device_id,
            'name' => $request->name ?? "",
            'type' => $request->type ?? "",
            'status' => $request->status ?? 'enabled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Access Control added successfully'
        ]);
    }

    public function editAccessControl(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'device_id' => 'required',
            'name' => '',
            'type' => '',
        ]);

        AccessControl::updateOrCreate([
            'id' => $request->id,
            'user_id' => auth()->id(),
            'device_id' => $request->device_id,
        ],[
            'name' => $request->name ?? "",
            'type' => $request->type ?? "",
            'status' => $request->status ?? 'enabled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Access Control updated successfully'
        ]);
    }

    public function deleteAccessControl(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $accessControl = AccessControl::find($request->id);

        $accessControl->delete();

        return response()->json([
            'success' => true,
            'message' => 'Access Control deleted successfully'
        ]);
    }
}
