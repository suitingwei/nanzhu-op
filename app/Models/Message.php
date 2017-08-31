<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    const TYPE_SYSTEM             = 'SYSTEM';
    const TYPE_BLOG               = 'BLOG';
    const TYPE_JUZU               = 'JUZU';
    const TYPE_NOTICE             = 'NOTICE';
    const TYPE_PLAN               = 'PLAN';                 //参考大计划
    const TYPE_CHAT_GROUP         = 'CHATGROUP';  //聊天类型,这个用户前端消息界面显示,并不是message这个表里的
    const TYPE_DAILY_REPORT       = 'DAILY_REPORT'; //没有撤销
    const TYPE_FRIEND_APPLICATION = 'FRIEND_APPLICATION'; //好友申请类型,这个用户前端消息界面显示,并不是message这个表里的
    const TYPE_FRIEND             = 'FRIEND'; //好友类型

    const SCOPE_ALL       = 0;
    const SCOPE_SOME_BODY = 1;

    const MESSAGE_HAD_READ = 1;
    const MESSAGE_NOT_READ = 0;

    const HAD_UNDO = 1; //已经撤销
    const NOT_UNDO = 0;

    protected $fillable = [
        "notice_type",
        "notice_id",
        "notice_file_id",
        "filename",
        "movie_id",
        "scope",
        "notice",
        "scope_ids",
        "type",
        "uri",
        "title",
        "content",
        "from",
        "to_user",
        "is_undo",
        "is_delete"
    ];

    /**
     * 所有发送消息的类型,并不包含为了用于前端显示而添加的好友申请和环信聊天类型
     */
    public static function allMessageTypes()
    {
        return [
            self::TYPE_BLOG,
            self::TYPE_JUZU,
            self::TYPE_NOTICE,
            self::TYPE_SYSTEM,
        ];
    }

    public static function types()
    {
        return [
            "DIAN"               => "南竹点对点推送",
            "SYSTEM"             => "系统消息",
            "BLOG"               => "扉页消息",
            "JUZU"               => "剧组通知",
            "NOTICE"             => "通告单",
            "PLAN"               => "参考大计划",
            'DAILY_REPORT'       => '日报表',
            'PREVIOUS_PROSPECT'  => '前期堪景',
            'GROUPUSER_FEEDBACK' => '组员反馈',
            'UNIONCOOPRAT'       => '联盟合作通知',
            'UNIONBIGNEWS'       => '联盟大事件',
            'UNIONNOTICE'        => '联盟通知',
            ''                   => '',
        ];
    }

    public static function is_undo($notice_id, $notice_file_id)
    {
        $message = Message::where("notice_id", $notice_id)->where("notice_file_id", $notice_file_id)->orderby("id",
            "desc")->first();

        if ($message && $message->is_undo == 1) {
            return true;
        }
        return false;
    }

    /**
     * 安卓的剧组通知,剧本扉页的上传图片
     * 前段上传完oss,直接post图片url
     *
     * @param $files
     * @param $message
     */
    private static function uploadMultipleImages($files, $message)
    {
        foreach ($files as $key => $file) {
            if ($file) {
                $picture             = new Picture;
                $picture->url        = $file;
                $picture->message_id = $message->id;
                $picture->save();
            }
        }
    }


    /**
     * ios上传图片,直接上传file
     *
     * @param $files
     * @param $message
     *
     */
    private static function uploadIosImages($files, $message)
    {
        foreach ($files as $key => $file) {
            if ($file) {
                $picture             = new Picture;
                $picture->url        = Picture::upload("pictures/" . $message->id, $file);
                $picture->message_id = $message->id;
                $picture->save();
            }
        }
    }

    /**
     * 获取推送通知的title,用于前端在app中显示
     *
     * @param $type
     *
     * @return string
     */
    private static function getMessageTitle($type)
    {
        $title = '';
        if ($type == 'juzu') {
            $title = '剧组通知';
        } elseif ($type == 'blog') {
            $title = '剧本扉页';
        }
        return $title;
    }

    public function toArray()
    {
        $array["id"]       = $this->id;
        $array["type"]     = $this->type;
        $array["title"]    = $this->title;
        $array["content"]  = $this->content;
        $array["scope"]    = $this->scope;
        $array["notice"]   = $this->notice;
        $array["filename"] = $this->filename;
        if ($this->type == "SYSTEM") {
            $array["filename"] = $this->title;
        }
        $array["uri"] = $this->uri;
        $carbon       = Carbon::createFromTimestamp(strtotime($this->created_at));
        $carbon->setLocale("zh");
        $array["created_at"] = $carbon->diffForHumans();
        $array["d"]          = $carbon->toDateString();
        $array["pictures"]   = $this->pictures();
        return $array;
    }

    public function pictures()
    {
        $arr      = [];
        $pictures = Picture::where("message_id", $this->id)->get();

        $count = Picture::where("message_id", $this->id)->count();
        if ($count > 0) {
            foreach ($pictures as $picture) {
                $arr[] = $picture->url;
            }
        }
        return $arr;
    }

    /**
     * 创建新的剧组通知
     *
     * @param Request $request
     * @param         $user_id
     *
     * @return static
     */
    public static function buildMessageData(Request $request, $user_id)
    {
        $data = $request->except("pic_url");

        if ($data['type'] == "blog") {
            $data['type'] = "BLOG";
        }

        if ($data['type'] == "juzu") {
            $data['type'] = "JUZU";
        }

        $data['from']      = $user_id;
        $data['scope']     = 1;
        $data["scope_ids"] = implode(',',
            GroupUser::where("FMOVIE", $data['movie_id'])->selectRaw('distinct FUSER')->lists('FUSER')->all());
        $movie             = Movie::where("FID", $data['movie_id'])->first();
        if ($movie) {
            $data['title'] = $movie->FNAME . ":" . $data['title'];
        }

        return self::create($data);
    }

    /**
     * @param Request $request
     * @param         $message
     */
    public static function uploadImages(Request $request, $message)
    {
        $files = $request->file('pic_url');

        //新版本如果是多张图片上传,会有一个multiple_upload变量为true
        if ($request->input('multiple_upload') == "true") {
            self::uploadMultipleImages($request->input('img_url'), $message);
        } elseif (count($files) > 0) {
            self::uploadIosImages($files, $message);
        }
    }

    /**
     * 创建新的剧组通知
     *
     * @param Request $request
     * @param         $userId
     */
    public static function createNewJuzuNofity(Request $request, $userId)
    {
        $message = self::buildMessageData($request, $userId);

        self::uploadImages($request, $message);

        $title = urlencode(self::getMessageTitle($request->input('type')));

        $message->uri = $request->root() . "/mobile/messages/{$message->id}?title={$title}";

        $message->save();

        $message->createMessageReceives();
    }


    /**
     * 创建接受推送
     */
    public function createMessageReceives()
    {
        $extra = ["uri" => $this->uri];
        foreach (explode(",", $this->scope_ids) as $user_id) {
            if ($user_id) {
                $receiver              = new MessageReceiver;
                $receiver->receiver_id = $user_id;
                $receiver->message_id  = $this->id;
                $receiver->is_read     = 0;
                $receiver->save();
                $user = User::where("FID", $user_id)->first();
                if ($user) {
                    if ($user->FALIYUNTOKEN) {
                        PushRecord::send(
                            $user->FALIYUNTOKEN,
                            '南竹通告单',
                            $this->title,
                            $this->title,
                            $extra,
                            false);
                    }
                }
            }
        }
    }


    /**
     * 创建有人购买专业版视频的推送消息
     *
     * @param $shootOrder
     *
     * @param $needToNotifyPerson
     *
     * @return static
     */
    public static function createProfessionalVideoPurchasedNofify($shootOrder, $needToNotifyPerson)
    {
        $order_no = strtotime($shootOrder->created_at) . $shootOrder->id;

        $message = self::create([
            'from'      => 0,
            'type'      => self::TYPE_SYSTEM,
            'content'   => "订单号为:{$order_no},下单用户名:{$shootOrder->contact},联系电话{$shootOrder->phone},客户希望录制时间为:{$shootOrder->start_date},请尽快与其联系",
            'title'     => '南竹通告单有新的订单',
            'scope'     => 1,
            'notice'    => '',
            'scope_ids' => implode(',', $needToNotifyPerson),
        ]);

        $message->update(['uri' => env('APP_URL') . "/mobile/messages/{$message->id}"]);

        //创建消息接受接受
        foreach ($needToNotifyPerson as $userId) {
            MessageReceiver::create([
                'receiver_id' => $userId,
                'message_id'  => $message->id,
                'is_read'     => 0
            ]);
        }
        return $message;
    }

    /**
     * 将某人从接受名单中去除
     *
     * @param $userId
     */
    public function removeUserFromReceivers($userId)
    {
        $scopeIdArray = explode(',', $this->scope_ids);

        if (!in_array($userId, $scopeIdArray)) {
            return;
        }

        $scopeIdArray = array_filter($scopeIdArray, function ($scopeId) use ($userId) {
            return $scopeId != $userId;
        });

        $this->update(['scope_ids' => implode(',', $scopeIdArray)]);


        $receivers = $this->receivers()->where('receiver_id', $userId)->get();

        foreach ($receivers as $receiver) {
            $receiver->delete();
        }
    }

    /**
     * 把用户加入消息的接受者
     *
     * @param $userId
     */
    public function addUserToReceivers($userId)
    {
        $scopeIdArray = explode(',', $this->scope_ids);

        if (in_array($userId, $scopeIdArray)) {
            return;
        }

        array_push($scopeIdArray, $userId);

        $this->update(['scope_ids' => implode(',', $scopeIdArray)]);

        MessageReceiver::create([
            'receiver_id' => $userId,
            'message_id'  => $this->id,
            'is_read'     => 0
        ]);

    }

    /**
     * 消息通知的接受者们
     * @return HasMany
     */
    public function receivers()
    {
        return $this->hasMany(MessageReceiver::class, 'message_id', 'id');
    }

    /**
     * 所有已读的接受者们
     * @return mixed
     */
    public function hadReadReceivers()
    {
        return $this->receivers()->where('message_receivers.is_read', 1);
    }

    /**
     * 查询向全体用户发送的通知
     *
     * @param $query
     *
     * @return
     */
    public function scopeToAll($query)
    {
        return $query->where('scope', self::SCOPE_ALL);
    }

    /**
     * 查询发给某一个用用户的
     *
     * @param $query
     * @param $userId
     * @param $type
     */
    public function scopeSendToUserWithType($query, $userId, $type)
    {
        if ($type) {
            $query->where('type', $type);
        }

        return $query->where(function ($query) use ($userId, $type) {
            $query->where('scope_ids', 'like', "%{$userId}%");

            if ($type && $type == self::TYPE_SYSTEM) {
                $query->orWhere('scope', 0);
            }

        });
    }

    /**
     * 通告单类型
     * 每日/预备
     *
     * @param $query
     * @param $type
     *
     * @return
     */
    public function scopeNoticeType($query, $type)
    {
        return $query->where('notice_type', $type);
    }

    /**
     * 消息的阅读率
     */
    public function readRate()
    {
        return $this->hadReadReceivers()->count() . '/' . $this->receivers()->count();
    }


    /**
     * 发送push消息
     *
     *
     * @return bool|void
     */
    public function push()
    {
        $extra['uri']  = $this->uri;
        $extra['type'] = $this->type;

        foreach (explode(",", $this->scope_ids) as $user_id) {
            $user = User::find($user_id);
            if ($user) {
                $receiver              = new MessageReceiver;
                $receiver->receiver_id = $user_id;
                $receiver->message_id  = $this->id;
                $receiver->is_read     = 0;
                $receiver->save();
                if ($user && $user->FALIYUNTOKEN) {
                    PushRecord::send($user->FALIYUNTOKEN, "南竹通告单+", $this->title, $this->title, $extra, false);
                }
            }
        }
    }

    /**
     * 撤销消息
     */
    public function undo()
    {
        $this->update(['is_undo' => self::HAD_UNDO]);

        //删除消息接受者
        $this->receivers->delete();
    }

    /**
     * 没有撤回的通告单
     *
     * @param $query
     *
     * @return
     */
    public function scopeNotUndo($query)
    {
        return $query->where('is_undo', self::NOT_UNDO);
    }

    /**
     * 是否已经撤回
     */
    public function isUndo()
    {
        return $this->is_undo == self::HAD_UNDO;
    }

    public function getReceiversWithInfo()
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
where messages.id= {$this->id} 
AND   messages.is_undo = 0
GROUP BY message_receivers .receiver_id
order by receivedAt DESC
SQL;
        return DB::select($sql);
    }

    public function plan()
    {
        return $this->belongsTo(ReferencePlan::class, 'plan_id', 'id');
    }

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class, 'daily_report_id', 'id');
    }
    /**
     * 剧组通知剧本扉页还允许后台上传文件
     * 所以可能有关联文件
     */
    public function files()
    {
        return $this->hasMany(MessageFiles::class, 'message_id', 'id');
    }
    /* 获取消息的uri*/
    public function getMessageUri(Request $request){
        if ($this->type == "NOTICE") {
            $uri = $this->uri;
        }
       else {
           $uri = env('MESSAGE_SEND_URL') . "/mobile/messages/" . $this->id;
       }
        $extra        = ["uri" => $uri];
        $this->uri = $uri;
        $this->save();

        return $this;
    }
}
