<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /*REGISTRO*/
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($this->redirectByLang($request))
            ->with('status', "Registro exitoso. Sesión iniciada como {$user->name}");
    }

    /* LOGIN*/
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Los datos no coinciden con nuestros registros.',
            ]);
        }

        $request->session()->regenerate();

        return redirect($this->redirectByLang($request))
            ->with('status', 'Sesión iniciada correctamente');
    }

    /*LOGOUT*/
    public function logout(Request $request)
    {
        $fromEn = $this->cameFromEn($request);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($fromEn ? route('en.home') : route('home'));
    }


    /*LÓGICA — DECIDIR A QUÉ HOME REDIRIGIR (ES o EN) */
    private function redirectByLang(Request $request): string
    {
        // Si el formulario trae el idioma explícito
        if ($request->input('lang') === 'en') {
            return route('en.home');
        }

        // Si viene desde /en o de una página en inglés
        if ($this->cameFromEn($request)) {
            return route('en.home');
        }

        // Si no, español
        return route('home');
    }


    /* DETECTAR SI LA REQUEST VIENE DE /en*/
    private function cameFromEn(Request $request): bool
    {
        // URL actual
        if ($request->is('en') || $request->is('en/*')) {
            return true;
        }

        // Referer
        $ref = (string) $request->headers->get('referer', '');
        if (str_starts_with($ref, url('/en'))) {
            return true;
        }

        return false;
    }
}
