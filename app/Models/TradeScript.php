<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TradeScript extends Model
{

    protected $guarded =[];
    public function receiveUsers()
    {
        if(empty($this->receive_user_ids)){
            return collect();
        }

        $receiveUserIds = explode(',', $this->receive_user_ids);

        return User::whereIn('FID', $receiveUserIds)->get();
    }

    public function pictures()
    {
       return $this->hasMany(Picture::class,'script_id','id') ;
    }
}
