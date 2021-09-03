<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name'        => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:11'],
            'cell_phone' => ['required', 'max:10'],
            'city_code'   => ['nullable', 'numeric'],
            'birth_date'  => ['required', 'date'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:6', 'max:10', 'confirmed'],
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

        $user = User::create([
            'name'          => $data['name'],
            'identification' => $data['identification'],
            'cell_phone'    => $data['cell_phone'],
            'city_code'     => $data['city_code'],
            'birth_date'    => $data['birth_date'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);

        $user->assignRole('Client');

        return $user;

    }

    /**
     *
     * Override Trait RegistersUsers : vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php
     *
    */
    public function register(Request $request)
    {

        $get_year_old = new User;

        if($get_year_old->getAge($request->input('birth_date')) < 18)
        {
            $notification = array(
                'message'    => 'Debe ser mayor de edad',
                'alert_type' => 'warning',);
    
            \Session::flash('notification', $notification);

            return back()->withInput()->withErrors(['birth_date', 'Debe ser mayor de edad']);
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }
        
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                    ?: redirect($this->redirectPath());
    }
}
