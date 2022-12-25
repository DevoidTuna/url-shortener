<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getLoginPage()
    {
        return view(
            'login', 
            [
                'notRegistered' => false
            ]
        );
    }

    public function getRegisterPage()
    {
        return view('register');
    }

    public function doRegister(Request $request)
    {
        if(!empty($request->all()))
        {
            $credentials = $request->validate([
                'name' => ['required', 'min:3'],   
                'email' => ['required', 'email'],   
                'password' => ['required', 'min:6', 'confirmed']
            ]);

            if($credentials) {
                $user = new User;
                $user->name = Str::upper($request->name);
                $user->email = Str::lower($request->email);
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::login($user);
                return redirect('user');
            } else {
                return redirect('register');
            }
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
        return view(
            'login', 
            [
                'notRegistered' => true
            ]
        );
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

    public function getEditUserPage()
    {
        return view(
            'editProfile', 
            [
                'user' => Auth::user(), 
                'passwordUpdate' => false, 
                'disabled' => ''
            ]
        );
    }

    public function updateUser(Request $request) 
    {
        User::where('id', '=', Auth::id())
            ->first()
            ->update(
                [
                    'name' => Str::upper($request->name),
                    'email' => Str::lower($request->email)
                ]
            );

        return redirect('user');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        User::where('id', '=', Auth::id())
            ->update(['password' => Hash::make($request->newPassword)]);
        
        return view(
            'editProfile', 
            [
                'user' => $user, 
                'passwordUpdate' => true, 
                'disabled' => 'disabled'
            ]
        );
    }
}
