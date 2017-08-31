<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoticeExcel extends Model
{
    protected $table = "t_biz_noticeexcelsinfo";

    protected $fillable = ['FID,FFILEADD,FNUMBER,FORSEND'];

    public $timestamps = false;

    public $appends = ['group_name', 'read_rate'];

    /**
     * @param $id
     *
     * @return NoticeExcel
     */
    public static function find($id)
    {
        return static::where('FID', $id)->first();
    }

    /**
     * 一个通告单文件对应一个通告单
     */
    public function notice()
    {
        return $this->belongsTo(Notice::class, 'FNOTICEEXCELID', 'FID');
    }

    /**
     * 判断文件是否发送
     * @return bool
     */
    public function is_send()
    {
        return Message::where("notice_file_id", $this->FID)->count() > 0;
    }

    /**
     * 一个通告单文件可以发送多条消息
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'notice_file_id', 'FID')
                    ->where('messages.notice_id', $this->notice->FID)
                    ->orderBy('id', 'desc');
    }

    /**
     * 返回通告单接受比率
     * @return int
     */
    public function getReadRateAttribute()
    {
        return $this->readRate();
    }

    /**
     * 获取文件url
     *
     * @param $userId
     *
     * @return string
     */
    public function getFileUrl($userId)
    {
        return "/mobile/notices/{$this->notice->FID}?excel_id={$this->FID}&user_id={$userId}&filename={$this->FFILEADD}";
    }

    /**
     * 通告单文件的阅读比例
     */
    public function readRate()
    {
        if ($this->messages->count() > 0) {
            return $this->messages()->first()->readRate();
        }
        return 0;
    }

    /**
     * 获取通告单文件所属的组别
     * A/B/C
     */
    public function getGroupNameAttribute()
    {
        if (!empty($this->custom_group_name)) {
            return $this->custom_group_name;
        }

        return explode(',', Notice::NOTICE_GROUPS)[$this->FNUMBER - 1] . '组通告单';
    }

    /**
     * Get the notice file's receivers.
     *
     * @return array
     */
    public function getNoticeFileRecivers()
    {
        $sql = <<<SQL
select 
       ifnull(t_biz_group .fname,'')      as groupName,
       ifnull(t_biz_groupuser.FREMARK,'') as `position`,
       ifnull(leader.FNAME,'')            as leaderName,
       t_sys_user.fname                   as userName,
       messages.created_at                as sendedAt,
       if(message_receivers.created_at= message_receivers.updated_at, '未读', message_receivers.updated_at) as receivedAt
from message_receivers
  inner JOIN messages on message_receivers.message_id=messages.id
  inner JOIN t_sys_user on t_sys_user.fid= message_receivers.receiver_id
  inner JOIN t_biz_groupuser on t_sys_user.fid=t_biz_groupuser.fuser
  inner JOIN t_biz_group on t_biz_group.FID=t_biz_groupuser.fgroup
  left join t_sys_user leader on leader.fid=t_biz_group.fleaderid
where messages.notice_file_id= {$this->FID} 
AND   messages.is_undo = 0
GROUP BY message_receivers .receiver_id
order by receivedAt DESC
SQL;
        return DB::select($sql);
    }

}
