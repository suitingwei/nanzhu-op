<?php

namespace App\Utils\MovieDataExporter;

use App\Models\Message;
use App\Models\Movie;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class NoticeFilesDownloader
 * @package App\Utils
 */
class MovieNotificationsExporter implements ExporterPath
{

    /**
     * @var Movie
     */
    private $movie;

    /**
     * @var
     */
    private $rootPath;
    private $messages;

    /**
     * NoticeFilesDownloader constructor.
     *
     * @param Movie $movie
     * @param       $movieRootPath
     */
    public function __construct(Movie $movie, $movieRootPath)
    {
        $this->movie = $movie;

        $this->__initPaths($movieRootPath);
        $this->_initMessages();
    }

    public function _initMessages()
    {
        $this->messages = Message:: where('movie_id', $this->movie->FID)
                                 ->where('type', Message::TYPE_JUZU)
                                 ->where('is_delete', 0)
                                 ->where('is_undo', 0)
                                 ->orderBy('created_at', 'asc')
                                 ->get();

    }

    /**
     * @param $movieRootPath
     */
    public function __initPaths($movieRootPath = '')
    {
        $this->rootPath = $movieRootPath . '/剧组通知';
        @mkdir($this->rootPath);
    }


    public function export()
    {
        \Log::info('---开始导出剧组通知---');
        $this->download()->exportReceviers();
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
        Excel::create("剧组通知接收详情", function ($excel) use ($sheetTitle) {
            $dates = [];

            foreach ($this->messages as $message) {
                $createDate = $message->created_at->toDateString();
                $receivers  = $message->getReceiversWithInfo();
                if (in_array($createDate, $dates)) {
                    $excel->setActiveSheetIndexByName($createDate);
                    $this->addReceiversToSheet($receivers, $excel->getSheet(), $message->title);
                } else {
                    array_push($dates, $createDate);
                    $excel->sheet($createDate, function ($sheet) use ($receivers, $sheetTitle, $message) {
                        $sheet->appendRow($sheetTitle);
                        $this->addReceiversToSheet($receivers, $sheet, $message->title);
                    });
                }
            }

            $excel->sheet(' ', function ($sheet) {
                $sheet->appendRow([' ']);
            });

            $excel->setActiveSheetIndex(0);
        })->save('xls', $this->rootPath);
    }

    /**
     * @param $receivers
     * @param $sheet
     * @param $planTitle
     */
    private function addReceiversToSheet($receivers, $sheet, $planTitle)
    {
        $sheet->appendRow([$planTitle]);
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

    public function download()
    {
        foreach ($this->messages as $message) {
            $pictures = $message->pictures();
            foreach ($pictures as $picture) {
                try {
                    $fileHandler = fopen($picture, 'r');
                    file_put_contents($this->rootPath . '/' . $message->title . 'jpg', $fileHandler);
                    fclose($fileHandler);
                } catch (\Exception $e) {
                    continue;
                }
            }
            $files = $message->files;
            foreach ($files as $file) {
                try {
                    $fileHandler = fopen($file->file_url, 'r');
                    file_put_contents($this->rootPath . '/' . $message->title . $file->file_name, $fileHandler);
                    fclose($fileHandler);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return $this;
    }
}
