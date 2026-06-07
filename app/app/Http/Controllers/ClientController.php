<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $includes = $this->parseIncludes($request, ['user', 'subscriptions']);
        $isAdvisor = $this->isAdvisor($request);

        $paginator = Client::with($includes)
            ->whereHas('user', fn ($q) => $q->where('account_status', 'verified'))
            ->paginate($this->perPage($request));

        $paginator->through(fn ($c) => $this->formatClient($c, $isAdvisor));

        return response()->json($paginator);
    }

    public function show(Request $request, Client $client)
    {
        $client->load(['user', 'helpRequests.category', 'subscriptions', 'appointments']);
        $isAdvisor = $this->isAdvisor($request);

        return response()->json($this->formatClient($client, $isAdvisor));
    }

    public function update(Request $request, Client $client)
    {
        $rules = [
            'personal_description' => ['nullable', 'string', 'max:500'],
            'status' => ['sometimes', 'in:seeking help,not seeking'],
            'membership_active' => ['sometimes', 'boolean'],
        ];

        if ($this->isAdvisor($request)) {
            $rules['background_notes'] = ['nullable', 'string'];
        }

        $data = $request->validate($rules);
        $client->update($data);

        return response()->json($this->formatClient($client, $this->isAdvisor($request)));
    }

    private function isAdvisor(Request $request): bool
    {
        $user = $request->user();

        return $user && $user->role === 'advisor';
    }

    private function formatClient(Client $client, bool $isAdvisor): array
    {
        $data = $client->toArray();

        if (! $isAdvisor) {
            unset($data['background_notes']);
        }

        return $data;
    }
}
