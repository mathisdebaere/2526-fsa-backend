<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Client;
use App\Models\Intake;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:45'],
            'last_name' => ['required', 'string', 'max:45'],
            'email' => ['nullable', 'email', 'unique:users', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:45', 'required_without:email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'date_of_birth' => ['nullable', 'date'],
            'role' => ['required', 'in:volunteer,client'],
            'privacy_agreement' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'role' => $data['role'],
            'privacy_agreement' => true,
            'privacy_agreement_timestamp' => now(),
        ]);

        match ($user->role) {
            'client'    => Client::create(['user_id' => $user->id]),
            'volunteer' => Volunteer::create(['user_id' => $user->id]),
        };

        Intake::create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        if ($user->email) {
            Mail::to($user->email)->send(new WelcomeMail($user));
        }

        return response()->json([
            'message' => 'Je registratie is succesvol ontvangen, we nemen contact met je op om je intake in te plannen',
            'user'    => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['nullable', 'email', 'required_without:phone'],
            'phone'    => ['nullable', 'string', 'required_without:email'],
            'password' => ['required'],
        ]);
        $user = isset($data['email'])
            ? User::where('email', $data['email'])->first()
            : User::where('phone', $data['phone'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['De opgegeven gegevens zijn onjuist'],
            ]);
        }

        if ($user->account_status === 'waiting_for_interview') {
            return response()->json([
                'message'        => 'Je account is nog niet goedgekeurd',
                'account_status' => 'waiting_for_interview',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Uitgelogd.']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load(['client', 'volunteer', 'advisor', 'address']));
    }
}
