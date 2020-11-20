<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('users.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->birth_date = $request->birth_date;
        $user->username = $request->username;

        $result['status'] = false;

        if ($request->password || $request->password_old) {
            $request->validate([
                'password' => 'required|string',
                'password_old' => 'required|string'
            ]);

            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password_old])) {
                $result['msg'] = 'Password yang anda masukan salah.';
                return response()->json($result);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        $result['status'] = true;
        return response()->json($result);
    }
}
