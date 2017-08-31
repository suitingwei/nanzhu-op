<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FakeUser
 * @package App
 */
class FakeUser extends Model
{
    /**
     *
     */
    const FAKE_USER_TOTAL_COUNT = 60;
    /**
     * @var array
     */
    public $guarded = [];

    /**
     * Register a phone will update the date atttirbute of the row.
     * @return bool
     */
    public static function isTodayRegisteredCompleted()
    {
        return self::todayCompletedCount() == self::FAKE_USER_TOTAL_COUNT;
    }

    /**
     * @return mixed
     */
    public static function todayCompletedCount()
    {
        return self::where('date', Carbon::now()->toDateString())->count();
    }

    /**
     * @return mixed
     */
    public static function getNextUnusedFakeUserInfo()
    {
        return self::where(function ($query) {
            $query->whereNull('date')
                  ->orWhere('date', '0000-00-00 00:00:00');
        })->orderBy('id')->first();
    }

    public static function leftPhonesCount()
    {
        return self::where(function ($query) {
            $query->whereNull('date')
                  ->orWhere('date', '0000-00-00 00:00:00');
        })->count();
    }
}
