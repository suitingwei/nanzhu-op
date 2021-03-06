<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'FID');
    }
}
