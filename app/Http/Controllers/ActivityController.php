<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'destination_id' => 'required|exists:destinations,id'
        ]);

        $activity = Activity::create($request->all());
        return response()->json($activity, 201);
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $activity->update($request->all());
        return response()->json($activity);
    }

    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);
        $activity->delete();
        return response()->json(null, 204);
    }
}
