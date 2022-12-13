<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{

    public function getPasswordReset()
    {
        $status = 0;
        return view('password.email', ['status' => $status]);
    }

    public function getPasswordNew($token)
    {
        $tokenData = DB::table('password_resets')
        ->where('token', $token)->first();

        if (empty($tokenData)) return view('password.email', ['status' => 'notToken']); ;

        $user = User::where('email', $tokenData->email)->first();

        if (empty($user)) return view('password.email', ['status' => 'notFound']);

        return view('password.reset', ['user' => $user]);
    }

    public function validatePasswordRequest(Request $request)
    {

        $user = User::where('email', '=', $request->email)->get();

        if (count($user) < 1) { 
            return view('password.email', ['status' => 'notFound']); 
        } 

        DB::table('password_resets')->insert([ 
                    'email' => $request-> email, 
                    'token' => Str::random(60), 
                    'created_at' => Carbon::now() 
        ]);

        $tokenData = DB::table('password_resets') 
                        ->where('email', '=', $request->email)
                        ->first('token'); 

        if ($this->sendResetEmail($request->email, $tokenData->token)) { 
            return view('password.email', ['status' => 'success']); 
        } else { 
            return view('password.email', ['status' => 'error']);
        }
    }

    public function sendResetEmail($email, $token)
    {
        $user = User::where('email', '=', $email)->first('name', 'email');
        $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
        $site = $protocol . '://'.$_SERVER['HTTP_HOST'] . '/';
        $link = $site . 'password/new/' . $token;

        try {
            Notification::route('mail', $email)->notify(new ResetPasswordNotification($link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('id', '=', $request->user)
                    ->first();

        try {
            $user->password = Hash::make($request->password);
            $user->update();

            Auth::login($user);

            DB::table('password_resets')
            ->where('email', $user->email)
            ->delete();

            return redirect('user');
        } catch (Exception $e) {
            return view('password.reset', ['user' => $user, 'status' => -1]);
        }
        
    }
}
