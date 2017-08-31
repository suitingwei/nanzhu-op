<?php

namespace App\Utils\MovieDataExporter;

use App\Models\DailyReport;
use App\Models\Message;
use App\Models\Movie;
use App\Models\Picture;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class NoticeFilesDownloader
 * @package App\Utils
 */
class DailyReportsExporter implements ExporterPath
{

    /**
     * @var Movie
     */
    private $movie;

    /**
     * @var
     */
    private $rootPath;

    /**
     * NoticeFilesDownloader constructor.
     *
     * @param Movie $movie
     * @param       $movieRootPath
     */
    public function __construct(Movie $movie, $movieRootPath)
    {
        //大计划文件夹
        $this->movie = $movie;

        $this->__initPaths($movieRootPath);
    }

    /**
     * @param $movieRootPath
     */
    public function __initPaths($movieRootPath = '')
    {
        $this->rootPath = $movieRootPath . '/场记日报表';
        @mkdir($this->rootPath);
    }

    /**
     * Download all uploaded files.
     */
    public function download()
    {
        $dailyReportIds = DailyReport::where('movie_id', $this->movie->FID)->pluck('id');
        $pictures       = Picture::whereIn('daily_report_id', $dailyReportIds)->get();

        foreach ($pictures as $index => $picture) {
            try {
                $fileHandler = fopen($picture->url, 'r');
                file_put_contents($this->rootPath . '/' . $index . '.jpg', $fileHandler);
                fclose($fileHandler);
            } catch (\Exception $e) {
                continue;
            }
        }
        return $this;
    }

    public function export()
    {
        \Log::info('---开始导出日报表---');
        $this->download()->exportReceviers()->exportDailyReports();
    }

    public function exportReceviers()
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
        Excel::create("场记日报表接收详情", function ($excel) use ($sheetTitle) {
            $dates    = [];
            $messages = Message::with('dailyReport')
                               ->where('movie_id', $this->movie->FID)
                               ->where('type', Message::TYPE_DAILY_REPORT)
                               ->where('is_delete', 0)
                               ->where('is_undo', 0)
                               ->orderBy('created_at', 'asc')
                               ->get();
            foreach ($messages as $message) {
                $createDate = $message->created_at->toDateString();
                $receivers  = $message->getReceiversWithInfo();
                if (in_array($createDate, $dates)) {
                    $excel->setActiveSheetIndexByName($createDate);
                    $this->addReceiversToSheet($receivers, $excel->getSheet(), $message->dailyReport->date);
                }
                else {
                    array_push($dates, $createDate);
                    $excel->sheet($createDate, function ($sheet) use ($receivers, $sheetTitle, $message) {
                        $sheet->appendRow($sheetTitle);
                        $this->addReceiversToSheet($receivers, $sheet, $message->dailyReport->date);
                    });
                }
            }

            $excel->sheet(' ', function ($sheet) {
                $sheet->appendRow([' ']);
            });

            $excel->setActiveSheetIndex(0);
        })->save('xls', $this->rootPath);

        return $this;
    }

    /**
     * @param $receivers
     * @param $sheet
     */
    private function addReceiversToSheet($receivers, $sheet, $title)
    {
        $sheet->appendRow([$title]);
        $lastRow = $sheet->getStartRow() - 1;
        $sheet->row($lastRow, function ($row) {
            // call cell manipulation methods
            $row->setBackground('#fefe00');
        });

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
     * @param DailyReport $dailyReport
     * @param             $sheet
     *
     * @internal param $receivers
     */
    private function addDailyReportToRow(DailyReport $dailyReport, $sheet)
    {
        $sheet->appendRow([$dailyReport->title]);
        $lastRow = $sheet->getStartRow() - 1;
        $sheet->row($lastRow, function ($row) {
            // call cell manipulation methods
            $row->setBackground('#fefe00');
        });
        $sheet->appendRow([
            $dailyReport->group,
            $dailyReport->authorUser->hx_name,
            $dailyReport->depart_time,
            $dailyReport->arrive_time,
            $dailyReport->action_time,
            $dailyReport->finish_time,
            $dailyReport->note,
        ]);
    }

    public function exportDailyReports()
    {
        static $sheetTitle = [
            '组',
            '发布者',
            '日期',
            '出发时间',
            '到场时间',
            '开拍时间',
            '结束时间',
            '备注',
        ];
        Excel::create("场记日报表", function ($excel) use ($sheetTitle) {
            $dailyReports = DailyReport::where('movie_id', $this->movie->FID)->get();
            $dates        = [];
            foreach ($dailyReports as $dailyReport) {
                $createDate = $dailyReport->created_at->toDateString();
                if (in_array($createDate, $dates)) {
                    $excel->setActiveSheetIndexByName($createDate);
                    $this->addDailyReportToRow($dailyReport, $excel->getSheet());
                }
                else {
                    array_push($dates, $createDate);
                    $excel->sheet($createDate, function ($sheet) use ($sheetTitle, $dailyReport) {
                        $sheet->appendRow($sheetTitle);
                        $this->addDailyReportToRow($dailyReport, $sheet);
                    });
                }
            }

            $excel->sheet(' ', function ($sheet) {
                $sheet->appendRow([' ']);
            });

            $excel->setActiveSheetIndex(0);
        })->save('xls', $this->rootPath);
    }
}
