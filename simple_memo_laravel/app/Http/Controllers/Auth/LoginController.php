<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Memo;
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

    /**d
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/memoselect';
    
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|max:255|email|regex:/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/',
                'password' => 'required|min:8|max:255|regex:/^[a-zA-Z0-9]+$/',
            ],
            [
                'password.regex' => ':attributeは半角英数字で入力してください。'
            ]
        );
    }
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $memo = Memo::where('user_id', '=', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->first();
        if ($memo) {
            session()->put('select_memo', $memo);
        }
    }        
}