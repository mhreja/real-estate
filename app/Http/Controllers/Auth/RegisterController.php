<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\EmailRegexRule;
use App\Rules\PhoneNoRegexRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $this->setPageTitle('Register', '');
        return view('auth.register');
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
            'name'      => 'required|string|max:255',
            'email'     => ['required', new EmailRegexRule, 'unique:users'],
            'phone_no'  => ['required', new PhoneNoRegexRule, 'unique:users'],
            'password'  => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $username   = $this->generateUniqueUsername($data['name']);
        $roleid     = isset($data['agent']) ? 2 : 3;

        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone_no'  => $data['phone_no'],
            'password'  => Hash::make($data['password']),
            'username'  => $username,
            'role_id'   => $roleid
        ]);
    }

    function generateUniqueUsername($name)
    {
        $username = Str::slug($name, ''); // Convert name to a slug format (e.g., john-doe)

        // Check if the generated username already exists in the user table
        $count = DB::table('users')->where('username', $username)->count();

        if ($count > 0) {
            // If the username already exists, append a unique number at the end
            $suffix = 1;
            while ($count > 0) {
                $newUsername = $username . '-' . $suffix;
                $count = DB::table('users')->where('username', $newUsername)->count();
                $suffix++;
            }
            $username = $newUsername;
        }

        return $username;
    }
}
