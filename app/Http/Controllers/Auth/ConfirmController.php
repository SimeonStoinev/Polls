<?php

namespace App\Http\Controllers\Auth;

//use App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConfirmController extends Controller
{


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index($confirmToken='')
    {
        $data = User::where('confirmToken', $confirmToken)->update(['confirmToken' => '', 'status' => 'active']);
        if($data){
            return redirect('/login')->with('msg-success', 'Вие потвърдихте вашата регистрация успешно.');
        }
    }

    public function mustConfirm()
    {
        if( Auth::check()){

            Session::flush();

            return redirect('/must-confirm');
        }

        return view('errors.must-confirm');
    }
}
