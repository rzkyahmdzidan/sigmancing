<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin
     *
     * @return \Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Proses autentikasi
        if (Auth::attempt($request->only('email', 'password'))) {
            // Cek apakah pengguna adalah admin
            if (Auth::user()->role === 'admin') {
                // Regenerasi sesi untuk keamanan
                $request->session()->regenerate();

                // Redirect ke dashboard admin
                return redirect()->route('admin.dashboard');
            }

            // Jika bukan admin, logout dan kembalikan dengan pesan error
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'Anda tidak memiliki akses admin.');
        }

        // Kembalikan error jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Proses logout admin
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Hancurkan sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login admin
        return redirect()->route('admin.login');
    }

    /**
     * Menampilkan halaman login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Proses autentikasi
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // Cek role pengguna
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect ke halaman admin
            }

            return redirect()->intended('/'); // Redirect ke halaman user
        }

        // Kembalikan error jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Menampilkan halaman register
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('frontend.register');
    }

    /**
     * Proses register
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role adalah user
        ]);

        // Login otomatis setelah pendaftaran
        Auth::login($user);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Proses logout
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Hancurkan sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/');
    }
}
