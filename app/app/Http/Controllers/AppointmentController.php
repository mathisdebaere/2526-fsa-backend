<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\VolunteerReview;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['sometimes', 'in:planned,completed,cancelled'],
            'type' => ['sometimes', 'in:introduction,assistance'],
            'client_id' => ['sometimes', 'exists:clients,id'],
            'volunteer_id' => ['sometimes', 'exists:volunteers,id'],
            'advisor_id' => ['sometimes', 'exists:advisors,id'],
        ]);

        $includes = $this->parseIncludes($request, ['client.user', 'volunteer.user', 'helpRequest.category', 'advisor.user']);

        $query = Appointment::with($includes)->latest();

        $user = $request->user();

        if ($user->role === 'client') {
            $query->where('client_id', $user->client->id);
        } elseif ($user->role === 'volunteer') {
            $query->where('volunteer_id', $user->volunteer->id);
        } elseif ($user->role === 'advisor') {
            $query->where('advisor_id', $user->advisor->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('volunteer_id')) {
            $query->where('volunteer_id', $request->volunteer_id);
        }

        if ($request->filled('advisor_id')) {
            $query->where('advisor_id', $request->advisor_id);
        }

        return response()->json($query->paginate($this->perPage($request)));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:introduction,assistance'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'location' => ['required', 'string', 'max:150'],
            'status' => ['nullable', 'in:planned,completed,cancelled'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'volunteer_id' => ['nullable', 'exists:volunteers,id'],
            'advisor_id' => ['nullable', 'exists:advisors,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'help_request_id' => ['nullable', 'exists:help_requests,id'],
        ]);

        if (isset($data['user_id'])) {
            $user = User::find($data['user_id']);
            if ($user->role === 'client') {
                $data['client_id'] = $user->client->id;
            } elseif ($user->role === 'volunteer') {
                $data['volunteer_id'] = $user->volunteer->id;
            }
            unset($data['user_id']);
        }

        $appointment = Appointment::create($data);

        return response()->json($appointment->load(['volunteer.user', 'advisor.user', 'client.user']), 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load([
            'client.user',
            'client.helpRequests.category',
            'volunteer.user',
            'advisor.user',
            'helpRequest.category',
        ]));
    }

    public function confirm(Request $request, Appointment $appointment)
    {
        $user = $request->user();

        if ($user->role !== 'client' || $appointment->client_id !== $user->client->id) {
            return response()->json(['message' => 'alleen de dienstvrager kan deze afspraak bevestigen.'], 403);
        }

        if ($appointment->status !== 'planned') {
            return response()->json(['message' => 'de afspraak kan niet meer bevestigd wordne.'], 422);
        }

        $data = $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $appointment->update(['status' => 'completed']);

        $review = VolunteerReview::create([
            'content' => $data['content'],
            'appointment_id' => $appointment->id,
            'volunteer_id' => $appointment->volunteer_id,
            'client_id' => $appointment->client_id,
        ]);

        return response()->json($review->load(['volunteer.user', 'client.user']), 201);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->noContent();
    }
}
