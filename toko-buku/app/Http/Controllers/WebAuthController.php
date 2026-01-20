<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
                ->withInput();
        }

        Auth::login($user);
        return redirect('/dashboard')->with('success', 'Berhasil masuk.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request, AuthController $authController)
    {
        $response = $authController->register($request);

        if ($response->getStatusCode() !== 201) {
            $data = $response->getData(true);
            $errors = [];

            if (isset($data['message'])) {
                $errors['email'] = $data['message'];
            }

            return back()
                ->withErrors($errors)
                ->withInput();
        }

        return redirect('/login')->with('success', 'Pendaftaran berhasil. Silakan masuk dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah keluar.');
    }
}
