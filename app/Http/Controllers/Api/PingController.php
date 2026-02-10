<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'uuid' => ['required', 'string'],
            'battery_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        Ping::create([
            'uuid' => $validated['uuid'],
            'battery_percent' => (int) $validated['battery_percent'],
        ]);

        return response()->json(['status' => 'ok']);
    }
}
