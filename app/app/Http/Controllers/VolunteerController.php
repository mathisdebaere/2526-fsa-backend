<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'available_on' => ['sometimes', 'date'],
            'time_of_day' => ['sometimes', 'in:morning,afternoon,evening'],
            'category_id' => ['sometimes', 'exists:help_request_categories,id'],
        ]);

        $includes = $this->parseIncludes($request, ['user', 'availabilities', 'categories']);

        $query = Volunteer::with($includes)
            ->whereHas('user', fn($q) => $q->where('account_status', 'verified'));

        if ($request->filled('available_on')) {
            $query->whereHas('availabilities', fn($q) => $q->where('date', $request->available_on));
        }

        if ($request->filled('time_of_day')) {
            $query->whereHas('availabilities', fn($q) => $q->where('time_of_day', $request->time_of_day));
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', fn($q) => $q->where('help_request_categories.id', $request->category_id));
        }

        $user = $request->user();

        if ($request->boolean('saved') && $user && $user->role === 'client') {
            $clientId = $user->client->id;
            $query->whereHas('favoritedByClients', fn($q) => $q->where('client_id', $clientId));
        }

        $paginator = $query->paginate($this->perPage($request));

        if ($user && $user->role === 'client') {
            $favoritedIds = $user->client->favoritedVolunteers()->pluck('volunteers.id')->all();
            $paginator->through(function (Volunteer $volunteer) use ($favoritedIds) {
                $volunteer->is_favorited = in_array($volunteer->id, $favoritedIds);
                return $volunteer;
            });
        }

        return response()->json($paginator);
    }

    public function show(Volunteer $volunteer)
    {
        return response()->json($volunteer->load(['user', 'availabilities', 'appointments', 'reviews.client.user', 'categories']));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $user = $request->user();

        if ($user->role === 'volunteer' && $user->volunteer->id !== $volunteer->id) {
            return response()->json(['message' => 'Je kan enkel je eigen profiel aanpassen.'], 403);
        }

        $data = $request->validate([
            'personal_description' => ['nullable', 'string', 'max:500'],
        ]);

        $volunteer->update($data);

        return response()->json($volunteer->load('user'));
    }

    public function reviews(Volunteer $volunteer)
    {
        return response()->json(
            $volunteer->reviews()->with('client.user', 'appointment.helpRequest.category')->latest()->get()
        );
    }

    public function addAvailability(Request $request, Volunteer $volunteer)
    {
        if ($request->user()->volunteer->id !== $volunteer->id) {
            return response()->json(['message' => 'Je kan enkel je eigen beschikbaarheden beheren'], 403);
        }

        $data = $request->validate([
            'date'        => ['required', 'date'],
            'time_of_day' => ['required', 'in:morning,afternoon,evening'],
        ]);

        $availability = $volunteer->availabilities()->create($data);

        return response()->json($availability, 201);
    }

    public function deleteAvailability(Request $request, Volunteer $volunteer, int $availabilityId)
    {
        $user = $request->user();

        if ($user->role !== 'advisor' && $user->volunteer->id !== $volunteer->id) {
            return response()->json(['message' => 'Je kan enkel je eigen beschikbaarheden beheren'], 403);
        }
        $availability = $volunteer->availabilities()->findOrFail($availabilityId);
        $availability->delete();

        return response()->noContent();
    }

    public function syncCategories(Request $request, Volunteer $volunteer)
    {
        if ($request->user()->volunteer->id !== $volunteer->id) {
            return response()->json(['message' => 'Je kan enkel je eigen categorieën beheren'], 403);
        }

        $data = $request->validate([
            'category_ids'   => ['required', 'array'],
            'category_ids.*' => ['integer', 'exists:help_request_categories,id'],
        ]);

        $volunteer->categories()->sync($data['category_ids']);

        return response()->json($volunteer->load('categories'));
    }
    public function favorite(Request $request, Volunteer $volunteer)
    {
        $client = $request->user()->client;
        $client->favoritedVolunteers()->syncWithoutDetaching([$volunteer->id]);

        return response()->json(['message' => 'Vrijwilliger opgeslagen als favoriet']);
    }

    public function unfavorite(Request $request, Volunteer $volunteer)
    {
        $client = $request->user()->client;
        $client->favoritedVolunteers()->detach($volunteer->id);

        return response()->json(['message' => 'Vrijwilliger verwijderd als favoriet']);
    }
}
