<?php

namespace App\Utils\MovieDataExporter;

use App\Models\Movie;
use App\User;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class NoticeFilesDownloader
 * @package App\Utils
 */
class AllMessageReceiversExporter implements ExporterPath
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
        $this->rootPath = $movieRootPath . '/全体接收详情';
        @mkdir($this->rootPath);
    }


    public function export()
    {
        \Log::info('---开始导出全体接受详情---');
        $this->exportReceviers();
    }

    public function exportReceviers()
    {
        static $sheetTitle = [
            '全部消息数',
            '已读数',
            '未读数',
            '接收比例',
            '用户',
            '部门',
            '职位',
            '接收时间(单位:小时)',
        ];
        Excel::create("全体接收详情", function ($excel) use ($sheetTitle) {
            $datas = DB::select(self::getSql($this->movie->FID));
            $excel->sheet("全体接收详情", function ($sheet) use ($datas, $sheetTitle) {
                $sheet->appendRow($sheetTitle);
                foreach ($datas as $data) {
                    $user = User::find($data->user_id);
                    $sheet->appendRow([
                        $data->all_count,
                        $data->read_count,
                        $data->un_read_count,
                        $data->read_percent,
                        $data->user_name,
                        $user->groupNamesInMovie($this->movie->FID),
                        $user->positionInMovie($this->movie->FID),
                        $data->cost_hours_per_messages,
                    ]);
                }
            });
        })->save('xls', $this->rootPath);

        return $this;
    }


    public static function getSql($movieId)
    {
        return <<<sql
SELECT
  count(DISTINCT message_id)                           AS all_count,
  sum(CASE WHEN is_read = 1
    THEN 1
      ELSE 0 END)                                      AS read_count,
  sum(CASE WHEN is_read = 0
    THEN 1
      ELSE 0 END)                                      AS un_read_count,
  sum(CASE WHEN is_read = 1
    THEN 1
      ELSE 0 END) / count(DISTINCT message_id)         AS read_percent,
  receiver_id as user_id,
  t_sys_user.FNAME as user_name,
  truncate((sum(
                CASE WHEN is_read = 0
                  THEN 0
                ELSE
                  (unix_timestamp(message_receivers.updated_at) - unix_timestamp(message_receivers.created_at))
                END
            ) / count(DISTINCT message_id)) / 3600, 2) AS cost_hours_per_messages
FROM message_receivers
  LEFT JOIN t_sys_user
    ON t_sys_user.FID = receiver_id
WHERE message_id IN (
  SELECT id
  FROM messages
  WHERE movie_id ={$movieId}  
        AND is_delete = 0
        AND is_undo = 0
)
GROUP BY receiver_id
ORDER BY read_percent DESC,cost_hours_per_messages ASC ;
sql;

    }

}
