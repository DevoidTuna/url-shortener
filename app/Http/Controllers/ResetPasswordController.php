<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use App\Models\User;
use App\Models\PasswordReset;
use Exception;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

  public function getPasswordNew($token)
  {
    try {
      $tokenData = PasswordReset::where('token', '=', $token)->first();
      if ($tokenData) {
        $user = User::where('email', '=', $tokenData->email)->first();
      } else {
        $user = false;
      }

      if (!$tokenData || !$user) {
        return response()->json([
          'status' => false,
          'message' => 'Token or user not found.'
        ], 404);
      }

      return response()->json([
        'email' => $user->email
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'status' => false,
        'message' => 'Fail. Contact support.',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function validatePasswordRequest(Request $request)
  {
    try {
      $user = User::where('email', '=', $request->email)->get();

      if (count($user) < 1) {
        return response()->json([
          'status' => false,
          'message' => 'User not found.'
        ], 404);
      }

      $resetPassword = new PasswordReset;
      $resetPassword->email = $request->email;
      $resetPassword->token = Str::random(60);
      $resetPassword->timestamps = false;
      $resetPassword->created_at = Carbon::now();

      $resetPassword->save();

      $tokenData = PasswordReset::where('email', '=', $request->email)
        ->first('token');

      $this->sendResetEmail($request->email, $tokenData->token);

      return response()->json(
        [
          'message' => 'Success. Email sent.'
        ],
        200
      );
    } catch (\Throwable $e) {
      return response()->json([
        'status' => false,
        'message' => 'Fail. Contact support.',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function sendResetEmail($email, $token)
  {
    $protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
    $site = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
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
    try {
      $token = PasswordReset::where('token', '=', $request->token)->first();

      if (!$token) {
        return response()->json(
          [
            'status' => false,
            'message' => 'Token not found.'
          ],
          404
        );
      }

      $user = User::where('email', '=', $request->email)
        ->first();

      $user->password = Hash::make($request->password);
      $user->update();

      PasswordReset::where('email', $user->email)
        ->delete();

      return response()->json([
        'message' => 'Password reset',
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => 'Fail. Try again or contact support.',
        'error' => $e->getMessage()
      ], 400);
    }
  }
}
