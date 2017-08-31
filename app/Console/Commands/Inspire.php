<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\MessageReceiver;
use App\Models\Notice;
use App\Models\NoticeExcel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->import_message();
        $this->removeDuplicatedMessageReceivers();
        //$this->change_read();
    }

    public function removeDuplicatedMessageReceivers()
    {
        $duplicatedMessageAndReceiverData = DB::select("SELECT id,message_id,receiver_id FROM message_receivers GROUP BY message_id,receiver_id HAVING count(id)>1; ");

        foreach ($duplicatedMessageAndReceiverData as $duplicatedData) {
            MessageReceiver::where([
                ['id', '!=', $duplicatedData->id],
                ['message_id', '=', $duplicatedData->message_id],
                ['receiver_id', '=', $duplicatedData->receiver_id],
            ])->delete();
        }
    }

    public function import_message()
    {
        $messages = Message::all();
        foreach ($messages as $message) {
            $excel = NoticeExcel::where("FFILEADD", $message->uri)->first();
            if ($excel) {
                $notice = Notice::where("FID", $excel->FNOTICEEXCELID)->first();
                if ($notice) {
                    $message->notice_id      = $notice->FID;
                    $message->notice_file_id = $excel->FID;
                    $message->notice_type    = $notice->FNOTICEEXCELTYPE;
                    $message->save();
                    echo $message->id . "\n";

                }
            }
        }
    }

    public function change_read()
    {
        $results = \DB::select("SELECT `t_biz_dailynereceive`.`FNOTICEEXCELID` ,`t_biz_dailynereceive`.`FRECEIVETIME` ,`t_biz_dailynereceive`.`FORRECEIVE` , `t_biz_dailynereceive`.`FNOTICEEXCELSINFOID` ,`t_biz_dailynereceive`.`FRECEIVETIME` ,`t_biz_groupuser`.FUSER FROM `nanzhu_pro`.`t_biz_dailynereceive` left join `t_biz_groupuser` on `t_biz_groupuser`.FID = `t_biz_dailynereceive` .FGROUPUSERID  where `t_biz_dailynereceive`.`FORRECEIVE`  = 10 ");
        foreach ($results as $result) {
            $message = Message::where("notice_id", $result->FNOTICEEXCELID)->where("notice_file_id",
                $result->FNOTICEEXCELSINFOID)->first();
            if ($message) {
                $receivers = MessageReceiver::where("message_id", $message->id)->get();
                foreach ($receivers as $receiver) {
                    if ($receiver->receiver_id == $result->FUSER) {
                        $receiver->is_read    = 1;
                        $receiver->updated_at = $result->FRECEIVETIME;
                        $receiver->save();
                        echo $receiver->id . "\n";
                    }

                }
                echo $message->id . "\n";
            }

        }

    }

}
