<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function getLoginPage()
    {
        $namePage = 'Login';
        return view('login', ['namePage' => $namePage]);
    }

    public function getRegisterPage()
    {
        $namePage = 'Register';
        return view('register', ['namePage' => $namePage]);
    }

    public function doRegister(Request $request)
    {  
        if(!empty($request->all()))
        {
            $user = new User;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $user->save();
            Auth::login($user);
            return redirect('user');
        }else {
            return redirect('register');
        }
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],   
            'password' => ['required' ,'min:6'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('user');
        }
        $notRegistered = 1;
        $namePage = 'Login';
        return view('login',
        ['namePage' => $namePage,
        'notRegistered' => $notRegistered ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
