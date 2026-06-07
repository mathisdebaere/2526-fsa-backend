<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IntakeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['sometimes', 'in:pending,scheduled'],
        ]);

        $includes = $this->parseIncludes($request, ['user', 'advisor', 'appointment']);

        $query = Intake::with($includes);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate($this->perPage($request)));
    }

    public function show(Intake $intake)
    {
        return response()->json($intake->load(['user', 'advisor', 'appointment']));
    }

    public function update(Request $request, Intake $intake)
    {
        $data = $request->validate([
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'notes' => ['nullable', 'string'],
            'advisor_id' => ['nullable', 'exists:users,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
        ]);

        if ($request->hasFile('document')) {
            if ($intake->document_url) {
                Storage::disk('public')->delete($intake->document_url);
            }
            $data['document_url'] = $request->file('document')->store('intakes', 'public');
        }
        unset($data['document']);

        if (array_key_exists('appointment_id', $data)) {
            $data['status'] = $data['appointment_id'] ? 'scheduled' : 'pending';

            if ($intake->appointment_id && $intake->appointment_id !== $data['appointment_id']) {
                $intake->appointment()->delete();
            }
        }

        $intake->update($data);

        return response()->json($intake->load(['user', 'advisor', 'appointment']));
    }
}
