<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2017/1/9
 * Time: 下午4:38
 */

namespace App\Utils\MovieDataExporter;


use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class GeneralStatsExporter
{
    private $movie;
    private $rootPath;

    /**
     * GeneralStatsExporter constructor.
     *
     * @param Movie $movie
     * @param       $movieRootPath
     */
    public function __construct($movie, $movieRootPath)
    {
        $this->movie    = $movie;
        $this->rootPath = $movieRootPath;
    }

    public function export()
    {
        \Log::info('开始构建总览数据导出...');
        $movie = $this->movie;
        Excel::create('总览', function ($excel) use ($movie) {

            $excel->sheet('New Sheet', function ($sheet) use ($movie) {
                $sheet->appendRow([
                    "剧名:《{$movie->FNAME}》\n创建于:{$movie->FNEWDATE}"
                ]);
                Log::info('剧名添加完毕');

                $this->_appendStartAndEndDate($sheet);
                Log::info('时间添加完毕');

                $this->_appendNoticesAndMessagesCount($sheet);
                Log::info('添加通告单信息');

                $sheet->appendRow([
                    "共进组{$movie->allMembersCount()}人"
                ]);
                Log::info('剧组人数添加完毕');

                $sheet->appendRow([
                    '部门',
                    '职位',
                    '人员名称',
                    '联系方式',
                    '进组时间'
                ]);
                Log::info('标题添加完毕');
                $userJoinMovieData = $this->movie->allUsersInMovie()->map(function ($user) {
                    return [
                        $user->groupNamesInMovie($this->movie->FID),
                        $user->positionInMovie($this->movie->FID),
                        $user->FNAME,
                        $user->FLOGIN,
                        $user->firstGroupUserInMovie($this->movie->FID)->FNEWDATE
                    ];
                })->sortBy(function ($userInfo) {
                    return strtotime($userInfo[4]);
                })->values()->all();


                foreach ($userJoinMovieData as $userInfo) {
                    $sheet->appendRow($userInfo);
                }

                Log::info('剧组成员添加完毕');

            });

            $excel->sheet(' ', function ($sheet) {
                $sheet->appendRow([' ']);
            });
            //坑爹的这个扩展,它内部的索引在对象消亡之后不会自动重置.在导出通告单接收详情的代码里有设置sheet索引的,但是在那一段代码执行完之后,
            //理应重置为0,
            $excel->setActiveSheetIndex(0);
        })->save('xls', $this->rootPath);
    }

    private function _appendStartAndEndDate($sheet)
    {
        if (!$this->movie->totalData) {
            return;
        }

        $startDate = Carbon::createFromTimestamp(strtotime($this->movie->totalData->FSTARTDATE));

        $endDate = Carbon::createFromTimestamp(strtotime($this->movie->notices()->orderBy('t_biz_noticeexcel.FNAME',
            'desc')->first()->FNAME));

        $costDays = $endDate->diffInDays($startDate);

        $sheet->appendRow([
            "开拍时间:{$startDate}\n结束时间:{$endDate}\n共计拍摄:{$costDays}天"
        ]);
    }

    private function _appendNoticesAndMessagesCount($sheet)
    {
        $dailyNoticesCount   = $this->movie->notices()->where('FNOTICEEXCELTYPE', 10)->count();
        $prepareNoticesCount = $this->movie->notices()->where('FNOTICEEXCELTYPE', 20)->count();
        $messagesCount       = $this->movie->messages()->where('type', 'JUZU')->count();

        $sheet->appendRow([
            "共发布了{$dailyNoticesCount}条每日通告单,{$prepareNoticesCount}条预备通告单\n发出剧组通知{$messagesCount}条"
        ]);
    }
}