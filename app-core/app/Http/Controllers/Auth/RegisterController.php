<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:t_users'], // Name must be unique
            'email' => ['required', 'string', 'email', 'max:255', 'unique:t_users'],
            'phone' => ['required', 'string', 'max:15', 'unique:t_users'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $slug = $this->generateUniqueSlug($data['name']);

        return User::create([
            'name' => $data['name'],  
            'slug' => $slug,          
            'email' => $data['email'],
            'phone' => $data['phone'], 
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function generateUniqueSlug($name)
    {
        // Generate initial slug
        $slug = Str::slug($name);

        // Check if the slug already exists in the t_users table
        $count = User::where('slug', 'LIKE', "{$slug}%")->count();

        // If the slug exists, append a unique identifier
        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }


    protected function registered(Request $request, $user)
    {
        // Flash a welcome message into the session
        session()->flash('welcome', 'Selamat datang, ' . $user->name . '! Terima kasih telah bergabung.');
    
        // Redirect to home
        return redirect($this->redirectPath());
    }
    
    

}
