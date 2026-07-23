<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'area'])->paginate(10);
        $roles = Role::all();
        $areas = Area::all();

        return view('admin.users.index', compact('users', 'roles', 'areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:20',
            'apellido_paterno' => 'required|max:10',
            'apellido_materno' => 'nullable|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
            'area_id' => 'required|exists:areas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'role_id.required' => 'Debes seleccionar un rol.',
            'area_id.required' => 'Debes seleccionar un área.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['estado'] = 'activo';

        User::create($validated);

        return back()->with('success', 'Usuario registrado exitosamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $user->estado = $user->estado === 'activo' ? 'inactivo' : 'activo';
        $user->save();

        return back()->with('success', 'Estado del usuario actualizado.');
    }
}
