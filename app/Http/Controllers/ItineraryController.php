<?php

namespace App\Http\Controllers;

use App\Models\{Itinerary, Category, Destination, ToVisit, Activity, Dish};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use Illuminate\Validation\Rule;

class ItineraryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|url',
            'destinations' => 'required|array|min:2',
            'destinations.*.name' => 'required|string|max:255',
            'destinations.*.accommodation' => 'required|string|max:255',
            'destinations.*.to_visits' => 'array|nullable',
            'destinations.*.to_visits.*.name' => 'required|string|max:255',
            'destinations.*.activities' => 'array|nullable',
            'destinations.*.activities.*.name' => 'required|string|max:255',
            'destinations.*.dishes' => 'array|nullable',
            'destinations.*.dishes.*.name' => 'required|string|max:255',
        ]);

        return DB::transaction(function () use ($validated) {
            $itinerary = Itinerary::create([
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'duration' => $validated['duration'],
                'image' => $validated['image'] ?? null,
            ]);

            foreach ($validated['destinations'] as $destinationData) {
                $this->createDestinationWithRelations($itinerary, $destinationData);
            }

            return response()->json($itinerary->load(['category', 'destinations']), 201);
        });
    }

    protected function createDestinationWithRelations(Itinerary $itinerary, array $data)
    {
        $destination = $itinerary->destinations()->create([
            'name' => $data['name'],
            'accommodation' => $data['accommodation'],
        ]);

        // Use correct relationship names
        collect(['toVisits', 'activities', 'dishes'])->each(function ($relation) use ($destination, $data) {
            if (!empty($data[$relation])) {
                foreach ($data[$relation] as $item) {
                    $destination->{$relation}()->create(['name' => $item['name']]);
                }
            }
        });
    }


    public function index()
    {
        return Itinerary::with(['category', 'destinations'])
            ->withCount('savers as favorites_count')
            ->paginate();
    }

    public function search(Request $request)
    {
        $query = Itinerary::with(['category', 'destinations'])
            ->when($request->q, fn($q, $keyword) => $q->where('title', 'like', "%$keyword%"));

        return $query->paginate();
    }

    public function filter(Request $request)
    {
        return Itinerary::with(['category', 'destinations'])
            ->when($request->category, fn($q) => $q->whereHas('category', fn($q) => $q->where('name', $request->category)))
            ->when($request->duration, fn($q) => $q->where('duration', '<=', $request->duration))
            ->orderBy('created_at', 'desc')
            ->paginate();
    }
}
