<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $fillable = [
    'name_link',
    'user_id',
    'shortened_link',
    'recipient_link',
    'expired_at',
    'public',
    'deleted_at'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
