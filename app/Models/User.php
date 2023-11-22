<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function nickname(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => $this->formatNickname($value)
    );
  }

  protected function email(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => strtolower($value)
    );
  }

  protected function password(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => Hash::make($value)
    );
  }

  private function formatNickname(string $nickname)
  {
    $formattedNickname = str_replace(' ', '-', $nickname);
    $formattedNickname = preg_replace('/[^0-9a-zA-Z-]/', '', $formattedNickname);

    return $formattedNickname;
  }

  public function links(): HasMany
  {
    return $this->hasMany(Link::class);
  }
}
