<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerFoundMail;
use App\Models\Appointment;
use App\Models\HelpRequest;
use App\Models\HelpRequestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpRequestController extends Controller
{
    public function categories()
    {
        return response()->json(HelpRequestCategory::all());
    }

    public function index(Request $request)
    {
        $request->validate([
            'status' => ['sometimes', 'in:open,matched,completed,cancelled'],
            'category_id' => ['sometimes', 'exists:help_request_categories,id'],
        ]);

        $includes = $this->parseIncludes($request, ['category', 'volunteer.user', 'client.user']);
        $query = HelpRequest::with($includes)->latest();

        $user = $request->user();
        if ($user->role === 'client') {
            $query->where('client_id', $user->client->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('help_request_category_id', $request->category_id);
        }

        return response()->json($query->paginate($this->perPage($request)));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'extra_notes' => ['nullable', 'string'],
            'region' => ['required', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'status' => ['nullable', 'in:open,matched,completed,cancelled'],
            'help_request_category_id' => ['required', 'exists:help_request_categories,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
        ]);

        $user = $request->user();
        if ($user->role === 'client') {
            $data['client_id'] = $user->client->id;
        } elseif (empty($data['client_id'])) {
            $data['client_id'] = $user->client->id;
        }

        $helpRequest = HelpRequest::create($data);

        return response()->json($helpRequest->load(['category', 'client.user']), 201);
    }

    public function show(HelpRequest $helpRequest)
    {
        return response()->json($helpRequest->load(['category', 'client.user', 'appointments']));
    }

    public function update(Request $request, HelpRequest $helpRequest)
    {
        $data = $request->validate([
            'extra_notes' => ['nullable', 'string'],
            'region' => ['sometimes', 'string', 'max:100'],
            'date' => ['sometimes', 'date'],
            'time' => ['sometimes', 'date_format:H:i'],
            'status' => ['sometimes', 'in:open,matched,completed,cancelled'],
            'help_request_category_id' => ['sometimes', 'exists:help_request_categories,id'],
        ]);

        $helpRequest->update($data);

        return response()->json($helpRequest);
    }

    public function accept(Request $request, HelpRequest $helpRequest)
    {
        if ($helpRequest->status !== 'open') {
            return response()->json(['message' => 'deze hulpvrag is niet meer beschikbaar'], 422);
        }
        $volunteer = $request->user()->volunteer;
        $appointment = Appointment::create([
            'type' => 'assistance',
            'date' => $helpRequest->date,
            'start_time' => $helpRequest->time,
            'location' => $helpRequest->region,
            'status' => 'planned',
            'volunteer_id' => $volunteer->id,
            'client_id' => $helpRequest->client_id,
            'help_request_id' => $helpRequest->id,
        ]);

        $helpRequest->update([
            'status' => 'matched',
            'volunteer_id' => $volunteer->id,
        ]);

        $clientUser = $helpRequest->client->user;
        if ($clientUser->email) {
            Mail::to($clientUser->email)->send(
                new VolunteerFoundMail($clientUser, $appointment->load(['volunteer.user', 'helpRequest.category']))
            );
        }

        return response()->json($appointment->load(['volunteer.user', 'client.user', 'helpRequest.category']), 201);
    }

    public function destroy(HelpRequest $helpRequest)
    {
        $helpRequest->delete();

        return response()->noContent();
    }
}
