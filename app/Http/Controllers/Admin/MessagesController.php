<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageReceiver;
use App\Models\Picture;
use App\Models\Profile;
use App\Models\PushRecord;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\DatabaseJob;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Print_;

class MessagesController extends Controller
{

    public function create()
    {
        return view("admin.messages.create");
    }

    public function index()
    {
        $messages = Message::orderBy("id", "desc")->paginate(30);
        return view("admin.messages.index", compact('messages'));
    }

    public function store(Request $request)
    {

        $this->creteMessage($request)->getMessageUri($request)->push();
        return redirect()->to("/admin/messages");
    }

    public function countNums(Request $request)
    {
        $position= $request->input('position');
        if($position) {
            $profileQueryBuilder = Profile::query();
            foreach (explode(',', $position) as $q) {
                if ($q != "") {
                    $profileQueryBuilder = $profileQueryBuilder->orWhere(function ($query) use ($q) {
                        $query->where('before_position', 'like', "%{$q}%")->orwhere('behind_position', 'like',
                            "%{$q}%")->pluck('user_id');
                    });
                }
            }
            return ['num' => $profileQueryBuilder->count()];
        }
    }

    /**
     * @param Request $request
     *
     * @return array
     * 返回的是创建的message
     */
    private function creteMessage(Request $request)
    {
        $data         = $request->except("pic_url");
        $files        = $request->file("pic_url");
        if($data['type']=='DIAN'){
            $data['from'] = -1;
        }
        else{
            $data['from'] = 0;
        }
        if($data['scope'] == 1) {
            $data['scope_ids'] = $this->getScopeIds($request);
        }
        else{
            $data['scope_ids'] = '';
        }

        $message = Message::create($data);
        $this->uploadPictures($message, $files);
        return $message;
    }

    /**
     * @param Request $request
     *
     * @return string
     * 返回的参数是  所有需要发送的用户的 id
     */
    private function getScopeIds(Request $request)
    {
        if ($request->input('position')) {
            $userQueryBuilder = Profile::query();
            foreach ($request->input('position') as $q) {
                $userQueryBuilder = $userQueryBuilder->orWhere(function ($query) use ($q) {
                    $query->where('before_position', 'like', "%{$q}%")->orWhere('behind_position', 'like', "%{$q}%");
                });
            }
            $SpecificUserId = $request->input('scope_ids');
            $allSelectedPostionsUserId = $userQueryBuilder->pluck('user_id')->all();
            array_push($allSelectedPostionsUserId, $SpecificUserId);
            $allUserId = implode(",", $allSelectedPostionsUserId);
            return $allUserId;
        }
        return $request->input('scope_ids');
    }

    /**
     * @param $message
     * @param $files
     * 如果有图片上传图片
     */
    private function uploadPictures($message, $files)
    {
        if ($message->type == "BLOG" || $message->type == "JUZU" || $message->type == 'SYSTEM' || $message->type == 'UNIONBIGNEWS' || $message->type == 'UNIONNOTICE' || $message->type == 'UNIONCOOPRAT' || $message->type == "DIAN" ) {
            foreach ($files as $key => $file) {
                if ($file) {
                    $picture             = new Picture;
                    $picture->url        = Picture::upload("pictures/" . $message->id, $file);
                    $picture->message_id = $message->id;
                    $picture->save();
                }
            }
        }
    }
}
