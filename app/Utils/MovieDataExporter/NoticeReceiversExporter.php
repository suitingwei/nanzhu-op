<?php
namespace App\Utils\MovieDataExporter;

use App\Models\Movie;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class NoticeReceiversExporter implements ExporterPath
{
    private $movie;
    private $noticesReceiversRootPath;
    private $dailyNoticeReceiversPath;
    private $prepareNoticeReceiversPath;

    public function __construct(Movie $movie, $movieRootPath)
    {
        $this->movie = $movie;
        $this->__initPaths($movieRootPath);
    }

    public function export()
    {
        \Log::info('---开始导出通告单接受详情---');
        $this->exportDailyReceivers();
        $this->exportPrepareReceivers();
    }

    private function exportDailyReceivers()
    {
        $this->exportReceiversToExcel(
            $this->movie->dailyNoticesFiles(),
            $this->getReceiversSaveFileName(10),
            $this->dailyNoticeReceiversPath
        );
    }

    /**
     * Export prepare noties receivers data to excel.
     */
    private function exportPrepareReceivers()
    {
        $this->exportReceiversToExcel(
            $this->movie->prepareNoticesFiles(),
            $this->getReceiversSaveFileName(20),
            $this->prepareNoticeReceiversPath
        );
    }

    /**
     * Get the the save name for the file.
     *
     * @param $movieId
     * @param $type
     *
     * @return mixed
     */
    private function getReceiversSaveFileName($type)
    {
        $sql        = <<<sql
SELECT min(FNAME) as min , max(FNAME) as max
FROM t_biz_noticeexcel 
where FMOVIEID =  {$this->movie->FID}
and fnoticeexceltype = {$type}
sql;
        $fileSuffix = $type == 10 ? '每日通告单' : '预备通告单';

        $dates = DB::select($sql)[0];

        if ($dates->min == $dates->max) {
            return "{$dates->min}" . $fileSuffix;
        }

        return "{$dates->min}~{$dates->max}" . $fileSuffix;
    }

    /**
     * @param $receivers
     * @param $sheet
     * @param $file
     */
    private function addReceiversToSheet($receivers, $sheet, $file)
    {
        $sheet->appendRow([$file->groupName]);
        $lastRow = $sheet->getStartRow() - 1;
        $sheet->row($lastRow, function ($row) {
            // call cell manipulation methods
            $row->setBackground('#fefe00');
        });

        if (count($receivers) == 0) {
//            Log::info('通告单文件'.$file->FID.'没有接受者');
            $sheet->appendRow(['未发送']);
            return;
        }

//        Log::info('通告单文件'.$file->FID.'有接受者');
        foreach ($receivers as $receiver) {
            $sheet->appendRow([
                $receiver->groupName,
                $receiver->position,
                $receiver->leaderName,
                $receiver->userName,
                $receiver->sendedAt,
                $receiver->receivedAt,
                $this->receiveCostTime($receiver->receivedAt, $receiver->sendedAt)
            ]);
        }
    }

    /**
     * Calculate the cost time for user to receive the notice message.
     *
     * @param $receivedAt
     * @param $sendedAt
     *
     * @return string
     */
    private function receiveCostTime($receivedAt, $sendedAt)
    {
        if ($receivedAt == '未读') {
            return '--';
        }

        Carbon::setLocale('zh');

        $sendDate     = Carbon::createFromTimestamp(strtotime($sendedAt));
        $receivedDate = Carbon::createFromTimestamp(strtotime($receivedAt));

        return $receivedDate->diffForHumans($sendDate);
    }

    /**
     * Export daily noties receivers data to excel.
     */
    private function exportReceiversToExcel($noticeFiles, $fileName, $path)
    {
        static $sheetTitle = [
            '所在部门',
            '职位',
            '部门长',
            '姓名',
            '发送时间',
            '接收时间',
            '接受速度'
        ];

        Excel::create($fileName, function ($excel) use ($noticeFiles, $sheetTitle) {
            $dates = [];
            foreach ($noticeFiles as $file) {
                $receivers  = $file->getNoticeFileRecivers();
                $createDate = Carbon::createFromTimestamp(strtotime($file->notice->FNAME))->toDateString();

                \Log::info('开始处理通告单文件'.$file);

                //If this file's create date has already exited.We'll append these receivers to the existing sheet.
                if (in_array($createDate, $dates)) {
                    $excel->setActiveSheetIndexByName($createDate);
                    $this->addReceiversToSheet($receivers, $excel->getSheet(), $file);
                } else {
                    array_push($dates, $createDate);

                    $excel->sheet($createDate, function ($sheet) use ($receivers, $sheetTitle, $file) {
                        $sheet->appendRow($sheetTitle);
                        $this->addReceiversToSheet($receivers, $sheet, $file);
                    });
                }
            }

            $excel->sheet(' ', function ($sheet) {
                $sheet->appendRow([' ']);
            });

            $excel->setActiveSheetIndex(0);

        })->save('xls', $path);
    }

    public function __initPaths($movieRootPath = '')
    {
        //通告单接收详情文件夹
        $this->noticesReceiversRootPath   = $movieRootPath . '/通告单接收详情';
        $this->dailyNoticeReceiversPath   = $this->noticesReceiversRootPath . '/每日通告单';
        $this->prepareNoticeReceiversPath = $this->noticesReceiversRootPath . '/预备通告单';

        @mkdir($this->noticesReceiversRootPath);
        @mkdir($this->dailyNoticeReceiversPath);
        @mkdir($this->prepareNoticeReceiversPath);
    }
}
