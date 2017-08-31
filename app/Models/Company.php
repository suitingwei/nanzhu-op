<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property mixed receive_user_ids
 */
class Company extends Model
{
    protected $guarded = [];

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'company_id', 'id');
    }

    /**
     * @return  Collection
     */
    public function receiveUsers()
    {
        if(empty($this->receive_user_ids)){
            return collect();
        }

        $receiveUserIds = explode(',', $this->receive_user_ids);

        return User::whereIn('FID', $receiveUserIds)->get();
    }

}
