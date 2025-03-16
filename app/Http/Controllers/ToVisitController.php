<?php

namespace App\Http\Controllers;

use App\Models\ToVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToVisitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'destination_id' => 'required|exists:destinations,id'
        ]);

        $toVisit = ToVisit::create($request->all());
        return response()->json($toVisit, 201);
    }

    public function update(Request $request, ToVisit $toVisit)
    {
        $this->authorize('update', $toVisit);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $toVisit->update($request->all());
        return response()->json($toVisit);
    }

    public function destroy(ToVisit $toVisit)
    {
        $this->authorize('delete', $toVisit);
        $toVisit->delete();
        return response()->json(null, 204);
    }
}
