<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailVerification;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $request->session()->flash('error', 'Registration has been disabled. Please contact the administrators for assistance');

        return redirect('login');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user -> name = $data['name'];
        $user -> email = $data['email'];
        $user -> password = bcrypt($data['password']);
        $user -> activation_code = str_random(60);
        $user -> save();
        $user -> roles()->attach(2);

        return $user;
    }

    /**
     *  Over-ridden the register method from the "RegistersUsers" trait
     *  Remember to take care while upgrading laravel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        /*
         * Laravel validation
         * */
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            $this->throwValidationException($request, $validator);
        }

        /*
         * Using database transactions is useful here
         * because stuff happening is actually a transaction
         **/
        DB::beginTransaction();

        try
        {
            $user = $this->create($request->all());
            /*
             * After creating the user send an email with the random code
             * generated in the create method above
             **/
            $email = new EmailVerification(new User(['activation_code' => $user->activation_code, 'name' => $user->name]));

            Mail::to($user->email)->send($email);

            DB::commit();

            $request->session()->flash('info', 'A verification email has been sent to you. Please verify your account before proceeding');

            return back();
        }
        catch(\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error', 'Something went wrong. Please try again');

            return back();
        }
    }

    public function activate(Request $request, $code)
    {
        /**
         * The verified method has been added to the user model
         * and chained here for better readability
         **/
        User::query()->where('activation_code', $code)->firstOrFail()->activated();

        $request->session()->flash('success', 'Successfully verified your account. You may proceed to login');

        return redirect('login');
    }
}
