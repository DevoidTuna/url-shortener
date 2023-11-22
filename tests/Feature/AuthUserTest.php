<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;

class AuthUserTest extends TestCase
{
  /**
   * A store of new user.
   */
  public function test_store_user(): void
  {
    $response = $this->postJson('/api/register', [
      'nickname' => Str::random(10),
      'email'    => fake()->email(),
      'password' => 'senha1234',
      'password_confirmation' => 'senha1234'
    ]);

    $response->assertStatus(200);
  }
}
