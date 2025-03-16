<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'destination_id' => 'required|exists:destinations,id'
        ]);

        $dish = Dishes::create($request->all());
        return response()->json($dish, 201);
    }

    public function update(Request $request, Dishes $dish)
    {
        $this->authorize('update', $dish);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string'
        ]);

        $dish->update($request->all());
        return response()->json($dish);
    }

    public function destroy(Dishes $dish)
    {
        $this->authorize('delete', $dish);
        $dish->delete();
        return response()->json(null, 204);
    }
}
