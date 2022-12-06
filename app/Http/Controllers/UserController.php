<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function getLoginPage()
    {
        return view('login');
    }

    public function getRegisterPage()
    {
        return view('register');
    }

    public function doRegister(Request $request)
    {  
        if(!empty($request->all()))
        {
            $user = new User;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            try {
                $user->save();
                Auth::login($user);
                return route('user');
            } catch (Exception $e) {
                return view('register');
            }
        }else {
            return view('register');
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
        return view('login',
        ['notRegistered' => $notRegistered]);
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
        $user = User::where('id', '=', auth()->id())->first(['name', 'email']);
        return view('editProfile', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {
        $user = User::where('id', '=', auth()->id())->first();

        if($request->name !== $user->name)
        {
            User::where('id', '=', $user->id)
                ->update(['name' => trim($request->name)]);
        }

        if($request->email !== $user->email)
        {
            User::where('id', '=', $user->id)
                ->update(['email' => trim($request->email)]);
        }

        if($request->newPassword !== null && Hash::check($request->newPassword, $user->password) == false)
        {
            User::where('id', '=', $user->id)
                ->update(['password' => bcrypt($request->newPassword)]);
        }

        return redirect('user');
    }
}
