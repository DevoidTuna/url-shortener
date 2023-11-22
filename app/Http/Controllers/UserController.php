<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
  private UserService $service;

  public function __construct(UserService $service)
    {
        $this->service = $service;
    }

  public function store(Request $request)
  {
    try {
      $request->validate([
        'nickname'  => ['required', 'min:3', 'max:60'],
        'email'     => ['required', 'email', 'unique:users'],
        'password'  => ['required', 'min:6', 'confirmed']
      ]);

      $user = $this->service->store($request->all());

      return response()->json([
        'message' => 'User created successfully.',
        'user'    => $user,
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message'  => $e->getMessage()
      ], 500);
    }
  }

  public function show()
  {
    try {
      $user = $this->service->show();

      if (!$user) {
        return response()->json([
          'message' => 'Not logged.'
        ], 404);
      }
      return response()->json([
        'data' => $user
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message'  => $th->getMessage()
      ], 500);
    }
  }

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $request->user()->token()->revoke();

    return response()->json([
      'message'    => 'Logout with success'
    ], 200);
  }

  public function update(Request $request)
  {
    try {
      $user = $this->service->update($request);

      return response()->json([
        'message'  => 'User updated!',
        'user'    => $user,
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message'  => $e->getMessage()
      ], 500);
    }
  }

  public function updatePassword(Request $request)
  {
    try {
      $this->service->updatePassword($request->password);

      return response()->json([
        'message'  => 'Password updated',
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message'  => $e->getMessage()
      ], 500);
    }
  }

  public function checkUniqueNickname(string $nickname)
  {
    try {
      $user = $this->service->checkUniqueNickname($nickname);

      if ($user) {
        return response()->json([
          'message' => 'Nickname aready in use',
          'avaliable' => false,
        ], 200);
      }

      return response()->json([
        'message' => 'Nickname avaliable',
        'avaliable' => true,
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'status'  => false,
        'message'  => $th->getMessage()
      ], 500);
    }
  }
}
