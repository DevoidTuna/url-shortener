<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
  public function store(array $newUser): User
  {
    $user = new User;

    $user->nickname = $newUser['nickname'];
    $user->email = $newUser['email'];
    $user->password = $newUser['password'];
    $user->save();

    return $user;
  }

  public function show(): User
  {
    return Auth::user();
  }

  public function update(object $data): User
  {
    $user = User::find(Auth::id());

    $user->nickname = $data->nickname;
    $user->email = $data->email;
    $user->save();

    return $user;
  }

  public function updatePassword(string $newPassword): User
  {
    $user = User::find(Auth::id());

    $user->password = $newPassword;
    $user->save();

    return $user;
  }

  public function checkUniqueNickname(string $nickname): User | null
  {
    $user = User::where('nickname', '=', $nickname)->first();

    return $user;
  }
}
