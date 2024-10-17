<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function loginPage()
    {
        return view('auth.login'); // Ensure the view file resources/views/auth/login.blade.php exists
    }

    public function loginPageLogic(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // Login successful
            $user = Auth::user();
            // Flash a welcome back message into the session
            session()->flash('welcome_back', 'Selamat datang kembali, ' . $user->name . '!');

            // Redirect users based on their user type
            switch ($user->type) {
                case 'admin':
                    return redirect()->route('dashboard');
                case 'customer':
                    return redirect()->route('home');
                default:
                    return redirect()->route('home');
            }
        } else {
            // Login failed, redirect back with error message
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['login' => 'Email atau password salah!']);
        }
    }




    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // Login berhasil
            $user = Auth::user();
            
            // Flash a welcome back message into the session
            session()->flash('welcome_back', 'Selamat datang kembali, ' . $user->name . '!');
            
            // Kembalikan respons JSON dengan sukses
            return response()->json([
                'success' => true,
                'user_type' => $user->type // Pastikan ada 'role' atau 'user_type' di user model
            ]);
        } else {
            // Login gagal, kembalikan respons JSON dengan success false
            return response()->json(['success' => false], 401);
        }
    }
    
    
}
