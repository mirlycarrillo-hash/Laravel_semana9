<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     * Si el usuario ya está autenticado, redirige al home.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Procesa el formulario de login.
     * 1. Valida que los campos no estén vacíos.
     * 2. Intenta autenticar al usuario con Auth::attempt().
     * 3. Si falla, regresa con mensaje de error.
     * 4. Si tiene éxito, guarda el carrito, regenera la sesión y lo restaura.
     */
    public function login(Request $request)
    {
        // Paso 1: Validar campos del formulario
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            // Mensajes de error personalizados en español
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingrese un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // Paso 2: Intentar autenticar
        $credenciales = $request->only('email', 'password');

        // 🚀 RESPALDO 1: Guardamos los productos del carrito antes de que Laravel regenere la sesión
        $carritoTemporal = session('carrito', []);

        if (Auth::attempt($credenciales)) {
            // Paso 3: Autenticación exitosa
            $request->session()->regenerate(); // Previene ataques de session fixation

            // 🚀 RESTAURACIÓN 1: Volvemos a meter el carrito en la nueva sesión del usuario logueado
            if (!empty($carritoTemporal)) {
                session(['carrito' => $carritoTemporal]);
            }

            return redirect()->route('home')->with('success', '¡Bienvenido, ' . Auth::user()->name . '!');
        }

        // Paso 4: Credenciales incorrectas
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email'); // Recuerda el email pero NO la contraseña
    }

    /**
     * Cierra la sesión del usuario actual sin perder el carrito.
     */
    public function logout(Request $request)
    {
        // 🚀 RESPALDO 2: Guardamos los productos del carrito antes de destruir la sesión activa
        $carritoTemporal = session('carrito', []);

        Auth::logout();

        // Se destruye la sesión vieja de forma segura
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🚀 RESTAURACIÓN 2: Inyectamos de vuelta el carrito en la nueva sesión de invitado limpia
        if (!empty($carritoTemporal)) {
            session(['carrito' => $carritoTemporal]);
        }

        return redirect()->route('login')->with('info', 'Ha cerrado sesión correctamente.');
    }
}