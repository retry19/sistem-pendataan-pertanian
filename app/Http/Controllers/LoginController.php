<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authentication(LoginRequest $request)
    {
        $credentials = $request->validated();
        $result['status'] = false;

        if (Auth::attempt($credentials)) {
            $result['redirect_to'] = route('dashboard');
            $result['status'] = true;
        }
        
        session()->flash('logged', 'Login Berhasil!');
        return response()->json($result);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.index');
    }
}
