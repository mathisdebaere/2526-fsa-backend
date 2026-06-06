<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['sometimes', 'in:pending,active,cancelled,expired'],
            'client_id' => ['sometimes', 'exists:clients,id'],
        ]);

        $includes = $this->parseIncludes($request, ['client.user']);

        $query = Subscription::with($includes);

        $user = $request->user();
        if ($user->role === 'client') {
            $query->where('client_id', $user->client->id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        return response()->json($query->orderByDesc('start_date')->paginate($this->perPage($request)));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'client_id' => ['required', 'exists:clients,id'],
        ]);

        $data['amount'] = $data['amount'] ?? 5.00;
        $data['status'] = 'pending';

        $subscription = Subscription::create($data);

        return response()->json($subscription->load('client.user'), 201);
    }
    public function update(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:pending,active,cancelled,expired'],
        ]);

        $subscription->update($data);

        return response()->json($subscription->load('client.user'));
    }

    public function pay(Subscription $subscription)
    {
        if ($subscription->status === 'active') {
            return response()->json(['message' => 'Abonnement is al betaald.'], 422);
        }

        $subscription->update([
            'status' => 'active',
            'paid_at' => now(),
        ]);

        return response()->json($subscription->load('client.user'));
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->noContent();
    }
}
