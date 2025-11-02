<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Mostrar todos los usuarios
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Crear un nuevo usuario
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Mostrar un usuario específico
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Actualizar un usuario
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Eliminar un usuario
    }
}
