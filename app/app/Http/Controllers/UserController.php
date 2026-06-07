<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:45'],
            'last_name' => ['sometimes', 'string', 'max:45'],
            'email' => ['sometimes', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['sometimes', 'string', 'max:45'],
            'date_of_birth' => ['nullable', 'date'],
            'account_status' => ['sometimes', 'in:waiting_for_interview,verified'],
        ]);

        $user->update($data);

        return response()->json($user);
    }

    public function verify(User $user)
    {
        $user->update(['account_status' => 'verified']);

        Intake::where('user_id', $user->id)->delete();

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function uploadPhoto(Request $request, User $user)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $existingPath = $user->getRawOriginal('profile_photo_url');
        if ($existingPath) {
            Storage::disk('public')->delete($existingPath);
        }
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->update(['profile_photo_url' => $path]);

        return response()->json(['profile_photo_url' => $user->profile_photo_url]);
    }
}
