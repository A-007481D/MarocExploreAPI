<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'accommodation' => 'required|string|max:255',
            'itinerary_id' => 'required|exists:itineraries,id'
        ]);

        $destination = Destination::create($request->all());
        return response()->json($destination, 201);
    }

    public function update(Request $request, Destination $destination)
    {
        $this->authorize('update', $destination);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'accommodation' => 'sometimes|string|max:255'
        ]);

        $destination->update($request->all());
        return response()->json($destination);
    }

    public function destroy(Destination $destination)
    {
        $this->authorize('delete', $destination);
        $destination->delete();
        return response()->json(null, 204);
    }
}
