<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadTrait;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Http\Request;

class TrackingApiController extends Controller
{
    use MediaUploadTrait;
    public function getTracking(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $tracking = Tracking::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'success' => true,
            'tracking' => $tracking ?? 'ID Not Match..',
        ]);
    }

    public function getTypeTracking(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'type' => 'required',
            'limit' => '',
        ]);

        $tracking = Tracking::where('device_id', $request->device_id)
            ->where('type', $request->type)
            ->where('user_id', auth()->id())
            ->paginate($request->limit ?? 10);

        return response()->json([
            'success' => true,
            'tracking' => $tracking ?? 'ID Not Match..',
        ]);
    }

    public function addTracking(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'type' => '',
            'data' => '',
        ]);

        $tracking = Tracking::create([
            'user_id' => auth()->id(),
            'device_id' => $request->device_id,
            'type' => $request->type,
            'data' => $request->data,
        ]);

        if ($request->hasFile('tracking_file')) {
            if (!$tracking->tracking_file || $request->file('tracking_file') !== $tracking->tracking_file->file_name) {
                $tracking->clearMediaCollection("tracking_file");
                $tracking->addMedia($request->file('tracking_file'))->toMediaCollection('tracking_file');
            }
        } elseif ($tracking->tracking_file) {
            $tracking->tracking_file->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Tracking Created successfully',
            'Tracking' => $tracking
        ]);
    }

    public function updateTracking(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => '',
            'data' => '',
        ]);

        $tracking = Tracking::updateOrCreate([
            'id' => $request->id,
            'user_id' => auth()->id(),
        ],[
            'device_id' => $request->device_id,
            'type' => $request->type ?? "",
            'data' => $request->data ?? "",
        ]);

        if ($request->hasFile('tracking_file')) {
            if (!$tracking->tracking_file || $request->file('tracking_file') !== $tracking->tracking_file->file_name) {
                $tracking->clearMediaCollection("tracking_file");
                $tracking->addMedia($request->file('tracking_file'))->toMediaCollection('tracking_file');
            }
        } elseif ($tracking->tracking_file) {
            $tracking->tracking_file->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Tracking Updated successfully',
            'Tracking' => $tracking
        ]);
    }

    public function deleteTracking(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $tracking = Tracking::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->first();

        $tracking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tracking delete successfully..',
        ]);
    }


}
