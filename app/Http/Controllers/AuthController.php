<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo debe tener un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // 1. Verificar si el usuario existe y está inactivo
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && $user->estado !== 'activo') {
            return back()->withErrors([
                'email' => 'Su cuenta se encuentra inactiva y no tiene permiso para ingresar al sistema.',
            ])->onlyInput('email');
        }

        $credentials['estado'] = 'activo';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
