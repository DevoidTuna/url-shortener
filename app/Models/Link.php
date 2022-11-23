<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'deleted'
    ];


    public function link()
    {   
        return $this->belongsTo(User::class);
    }
}
