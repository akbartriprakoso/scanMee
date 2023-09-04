<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'avatar' => ['max:5048','image','mimes:jpeg,png,jpg'],
            'username' => ['required','max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]);

        $user = Auth::user();
        // Memeriksa apakah pengguna mengunggah avatar baru
        if ($request->hasFile('avatar')) {
            // Menghapus avatar lama jika ada
            if ($user->avatar) {
                Storage::delete('public/img/profile/' . $user->avatar);
            }

            // Menyimpan avatar baru di folder public/avatars
            $avatar = $request->file('avatar');
            $avatar_name = $user->id . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/img/profile/', $avatar_name);

            // Mengupdate nama avatar di database
            $user->avatar = $avatar_name;
        }
        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->postal = $request->postal;
        $user->about = $request->about;
        $user->save();

        // Mengembalikan halaman profil dengan pesan sukses
        return back()->with('succes', 'profile succesfully updated');
    }
}
