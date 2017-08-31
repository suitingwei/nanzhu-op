<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string invest_types
 * @property mixed  end_date
 * @property mixed  start_date
 * @property mixed  budget_top
 * @property mixed  budget_bottom
 */
class ClientMovieRequirement extends Model
{
    const TYPE_CLIENT = 'CLIENT';
    const TYPE_MOVIE  = 'MOVIE';

    static $investTypes = ['植入', '赞助', '投资'];
    static $movieTypes = ['电影', '网大', '电视剧'];
    static $rewardTypes = ['片尾Logo', '片花使用', '冠名'];

    public static $storeRules = [
        'invest_types'  => 'required',
        'movie_types'   => 'required',
        'reward_types'  => 'required',
        'start_date'    => 'required|date',
        'end_date'      => 'required|date|time_greater_than_field:start_date',
        'budget_bottom' => 'required|numeric',
        'budget_top'    => 'required|numeric|greater_than_field:budget_bottom',
    ];

    public $guarded = [];

    public $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * @return array
     */
    public function normalizedInvestTypes()
    {
        return $this->normalizeTypes('invest_types');
    }

    /**
     * @return array
     */
    public function normalizedMovieTypes()
    {
        return $this->normalizeTypes('movie_types');
    }

    /**
     * @return array
     */
    public function normalizedRewardTypes()
    {
        return $this->normalizeTypes('reward_types');
    }

    /**
     * @param $attribute
     * @return array
     */
    private function normalizeTypes($attribute)
    {
        $investData     = explode(',', $this->{$attribute});
        $staticProperty = Str::camel($attribute);

        return array_map(function ($defaultInvestType) use ($investData) {
            return (int)in_array($defaultInvestType, $investData);
        }, self::$$staticProperty);
    }

}
