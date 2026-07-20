<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Illuminate\Http\Request;

class Login extends Component
{
    public $username = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'username' => 'required|string',
        'password' => 'required|string',
    ];

    protected $messages = [
        'username.required' => 'Username tidak boleh kosong.',
        'password.required' => 'Password tidak boleh kosong.',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('portal'));
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Bersihkan session dan token CSRF demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tendang kembali ke halaman Login (route bernama 'login' atau URL '/')
        return redirect()->route('login');
    }

    #[Layout('layouts.auth')] 
    public function render()
    {
        return view('livewire.auth.login');
    }
}