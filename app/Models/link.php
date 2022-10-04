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
        'user_id',
        'shortened_link',
        'recipient_link',
        'private'
    ];

    protected $dates = [
        'expirated_at',
        'deleted_at'
    ];

    public function link()
    {
        return $this->belongsTo(User::class);
    }
}
