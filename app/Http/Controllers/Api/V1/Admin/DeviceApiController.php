<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceApiController extends Controller
{
    public function getDevice(Request $request)
    {
        $request->validate([
            'limit' => '',
        ]);

        $device = Device::where('user_id', auth()->id())
            ->paginate($request->limit);

        return response()->json([
            'success' => true,
            'device' => $device ?? "ID Not Match.."
        ]);
    }

    public function addDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'unique_number' => 'required',
        ]);

        $device = Device::create([
            'user_id' => auth()->id(),
            'device_id' => $request->device_id ?? "",
            'unique_number' => $request->unique_number ?? "",
            'status' => $request->status ?? 1,
            'data' => $request->data
        ]);

        return response()->json([
            'success' => true,
            'message' => "Device Added Successfully",
            'device' => $device ?? "ID Not Match.."
        ]);
    }

    public function updateDevice(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'device_id' => 'required',
            'unique_number' => 'required',
        ]);

        $device = Device::updateOrCreate([
            'id' => $request->id,
            'user_id' => auth()->id(),
        ],[
            'device_id' => $request->device_id ?? "",
            'unique_number' => $request->unique_number ?? "",
            'status' => $request->status ?? 1,
            'data' => $request->data
        ]);

        return response()->json([
            'success' => true,
            'message' => "Device Updated Successfully",
            'device' => $device ?? "ID Not Match.."
        ]);
    }

    public function deleteDevice(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $device = Device::find($request->id);

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device Deleted Successfully'
        ]);
    }
}
