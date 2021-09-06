<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginFromTraining()
    {
        $validator = Validator::make(request()->all(), [
            'token' => ['required', 'string', 'exists:mysql_training.ta_user,access_token'],
        ]);

        if ($validator->fails()) {
            return view('auth.login')->withErrors($validator);
        } else {
            $data = $validator->validated();

            $user = User::where('access_token', $data['token'])->firstOrFail();

            auth()->login($user);

            return redirect('/');
        }
    }
}
