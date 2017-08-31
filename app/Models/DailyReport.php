<?php

namespace App\Models;

use App\Interfaces\ReadStatus;
use App\Managers\PowerManager;
use App\Traits\MessageReadCalator;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;


/**
 * @property Movie   movie
 * @property integer author
 * @property integer movie_id
 * @property string  group
 * @property User    authorUser
 * @property Carbon  depart_time
 * @property Carbon  action_time
 * @property Carbon  arrive_time
 * @property Carbon  finish_time
 * @property Carbon  date
 */
class DailyReport extends Model
{
    /**
     * @var array
     */
    public $guarded = [];

    /**
     * 发送给接受者
     */
    public function pushMessages()
    {
        $message = $this->createPushMessage();

        $message->push(true, ['daily_report_id' => $this->id]);
    }

    /**
     * 一个场记日报表属于一个剧组
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'FID');
    }

    /**
     * 一个场记日报表有一个创建者
     */
    public function authorUser()
    {
        return $this->belongsTo(User::class, 'author', 'FID');
    }

    /**
     * 一个日报表可能有多个图片
     */
    public function pictures()
    {
        return $this->hasMany(Picture::class, 'daily_report_id', 'id');
    }


    /**
     * 上传场记日报表关联的图片
     *
     * @param $imageUrlArray
     */
    public function createRelativeImages($imageUrlArray)
    {
        foreach ($imageUrlArray as $url) {
            if (empty($url)) {
                continue;
            }

            Picture::create([
                'url'             => $url,
                'daily_report_id' => $this->id
            ]);
        }
    }

    /**
     * 获取周一周二这样的属性
     * @return string
     */
    public function getChineseWeekDayAttribute()
    {
        static $chineseWeekDay = ['日', '一', '二', '三', '四', '五', '六'];

        return $chineseWeekDay[$this->created_at->dayOfWeek];
    }

    /**
     * 获取简短的备注
     * @return string
     */
    public function getShortNoteAttribute()
    {
        return mb_substr($this->note, 0, 54);
    }


    /**
     * 拼接日报表title
     */
    public function getTitleAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->date)->format('Y年m月d日');

        return "{$this->group}组 {$date}({$this->chinese_week_day})";
    }

    /**
     * 获取出发时间
     * @return string
     */
    public function getShortDepartTimeAttribute()
    {
        return $this->formatTimeAttribute($this->attributes['depart_time']);
    }

    /**
     * 获取达到时间
     * @return string
     */
    public function getShortArriveTimeAttribute()
    {
        return $this->formatTimeAttribute($this->attributes['arrive_time']);
    }

    /**
     * 获取开拍时间
     * @return string
     */
    public function getShortActionTimeAttribute()
    {
        return $this->formatTimeAttribute($this->attributes['action_time']);
    }

    /**
     * 获取收工时间
     * @return string
     */
    public function getShortFinishTimeAttribute()
    {
        return $this->formatTimeAttribute($this->attributes['finish_time']);
    }

    /**
     * 格式化时间
     *
     * @param Carbon $time
     *
     * @return string
     */
    private function formatTimeAttribute($time)
    {
        if ($time == 0) {
            return '';
        }

        if (!($time instanceof Carbon)) {
            $time = Carbon::createFromTimestamp(strtotime($time));
        }

        if ($time->day != Carbon::createFromTimestamp(strtotime($this->date))->day) {

            return $time->format('H:i(m月d日)');
        }

        return $time->format('H:i');
    }

    /**
     * 获取h5接收详情url
     */
    public function getH5ReceiversUrl()
    {
        return env('APP_URL') . "/mobile/daily-reports/{$this->id}/receivers?movie_id={$this->movie_id}";
    }

    /**
     * Get the chinese date format.
     */
    public function getChineseDateAttribute()
    {
        $date = Carbon::createFromTimestamp(strtotime($this->date));

        return $date->format('Y年m月d日');
    }

    /**
     * @param $id
     *
     * @return DailyReport
     */
    public static function find($id)
    {
        return static::where('id', $id)->first();
    }


    /**
     * 场记日报表和其他的剧组通知,剧本扉页不一样,这东西没有撤回发送
     * 只有当更新内容的时候让所有人重新编程未读
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'daily_report_id', 'id');
    }
}



