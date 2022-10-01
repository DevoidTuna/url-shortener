<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class link extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'shortened_link',
        'recipient_link'
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
