<?php
namespace App\Utils\MovieDataExporter;


use App\Models\Movie;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Screen\Capture;

/**
 * Class DailyDataSnapShooter
 * @package App\Utils\MovieDataExporter
 */
class DailyDataSnapShooter implements ExporterPath
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
     * @var
     */
    private $dailyTotalPath;
    /**
     * @var
     */
    private $planAndFactScenesPath;
    /**
     * @var
     */
    private $planAndFactPagesPath;
    /**
     * @var
     */
    private $totalScenesPath;
    /**
     * @var
     */
    private $totalPagesPath;

    /**
     * @var string
     */
    private $rootChartUrl = 'https://chart.nanzhuxinyu.com/chart/charts/progresschart_api.jsp';

    /**
     * DailyDataSnapShooter constructor.
     *
     * @param Movie $movie
     * @param       $movieRootPath
     */
    public function __construct($movie, $movieRootPath)
    {
        $this->movie = $movie;

        $this->__initPaths($movieRootPath);
    }

    /**
     * @param string $movieRootPath
     */
    public function __initPaths($movieRootPath = '')
    {
        //数据图形文件夹
        $this->rootPath              = $movieRootPath . '/数据图形';
        $this->dailyTotalPath        = $this->rootPath . '/当日合计实际拍摄场镜&页数';
        $this->planAndFactScenesPath = $this->rootPath . '/计划场镜对比实拍场镜';
        $this->planAndFactPagesPath  = $this->rootPath . '/计划页数对比实拍页数';
        $this->totalScenesPath       = $this->rootPath . '/全剧累计拍摄场镜';
        $this->totalPagesPath        = $this->rootPath . '/全剧累计拍摄页数';

        @mkdir($this->rootPath);
        @mkdir($this->dailyTotalPath);
        @mkdir($this->planAndFactScenesPath);
        @mkdir($this->planAndFactPagesPath);
        @mkdir($this->totalScenesPath);
        @mkdir($this->totalPagesPath);
    }

    /**
     *
     */
    public function export()
    {
        \Log::info('---开始导出每日数据截图---');
        $this->exportPlanAndFactPagesScenes();
        $this->exportDailyTotal();
        $this->exportTotalScenes();
        $this->exporTotalPages();
    }

    /**
     *
     */
    private function exportDailyTotal()
    {
        foreach ($this->_getProgressData() as $index => $progressDataIdChunk) {
            $url = $this->rootChartUrl . $this->_buildHttpQuery([
                    'chartId'               => 1,
                    'juzuId'                => $this->movie->FID,
                    'sProgressDailyDataIds' => $progressDataIdChunk->pluck('FID')->implode(',')
                ]);
            Log::info('每日累计拍摄:' . $url);
            $this->_snapUrlShoot($url, $index, $this->dailyTotalPath);
        }
    }

    /**
     *
     */
    private function exportPlanAndFactPagesScenes()
    {
        static $groupDataNumbers = [1, 2, 3, 4, 5];
        static $pagesQueryParameters = ['a2', 'b2', 'c2', 'd2', 'e2'];
        static $scenesQueryParameters = ['a1', 'b1', 'c1', 'd1', 'e1'];

        foreach ($groupDataNumbers as $groupDataNumber) {
            $dailyDataIds = $this->_getNotEmptyDailyDataIds($groupDataNumber);

            if (count($dailyDataIds) == 0) {
                continue;
            }

            list($pageDictionary, $sceneDictionary) = $this->createGroupDataDictionary($pagesQueryParameters,
                $groupDataNumber);


            $dailyDataIds = array_map(function ($dataId) {
                return $dataId->FID;
            }, $dailyDataIds);

            foreach (array_chunk($dailyDataIds, 10) as $index => $dailyDataIdsChunk) {
                Log::info($index . '每日数据id切片' . json_encode($dailyDataIdsChunk));
                list($pageUrl, $sceneUrl) = $this->buildSnapUrl($pagesQueryParameters,
                    $groupDataNumber, $dailyDataIdsChunk, $scenesQueryParameters);

                $this->_snapUrlShoot($pageUrl, $index + 1, $pageDictionary);
                $this->_snapUrlShoot($sceneUrl, $index + 1, $sceneDictionary);

                Log::info('计划和实际拍摄页数' . $pageUrl);
                Log::info('计划和实际拍摄场景' . $sceneUrl);
            }

        }
    }

    /**
     *
     */
    private function exporTotalPages()
    {
        $url = $this->rootChartUrl . $this->_buildHttpQuery([
                'chartId' => 4,
                'juzuId'  => $this->movie->FID,
            ]);
        Log::info('总页数:' . $url);
        $this->_snapUrlShoot($url, 1, $this->totalPagesPath);
    }

    /**
     *
     */
    private function exportTotalScenes()
    {
        $url = $this->rootChartUrl . $this->_buildHttpQuery([
                'chartId' => 2,
                'juzuId'  => $this->movie->FID,
            ]);

        $this->_snapUrlShoot($url, 1, $this->totalScenesPath);
    }

    /**
     * @param array $queryData
     *
     * @return string
     */
    private function _buildHttpQuery(array $queryData = [])
    {
        return '?' . http_build_query($queryData);
    }

    /**
     * @return array
     */
    private function _getProgressData()
    {
        static $progressDailyDataIds = null;

        if (!is_null($progressDailyDataIds)) {
            return $progressDailyDataIds;
        }

        return $progressDailyDataIds = $this->movie->progressDailyData->chunk(10)->all();
    }

    /**
     * 获取剧组某一个摄制组的所有有拍摄数据的每日数据id,
     * 如果没有,返回空
     *
     * @param $groupNumber
     *
     * @return mixed
     */
    private function _getNotEmptyDailyDataIds($groupNumber)
    {
        $sql = <<<sql
        SELECT
  t_biz_progressdailydata.FID
FROM t_biz_progressdailygrdata
  LEFT JOIN t_biz_progressdailydata ON t_biz_progressdailydata.FID = t_biz_progressdailygrdata.FDAILYDATAID
WHERE t_biz_progressdailydata.FMOVIEID ={$this->movie->FID}  
      AND (t_biz_progressdailygrdata.FDAILYSCENE != 0
           OR t_biz_progressdailygrdata.FPLANSCENE != 0
           OR t_biz_progressdailygrdata.FPLANPAGE != 0
           OR t_biz_progressdailygrdata.FDAILYPAGE != 0
          )
          AND t_biz_progressdailygrdata.FGROUPID ={$groupNumber}
ORDER BY t_biz_progressdailygrdata.FDAILYDATAID ASC
sql;

        return DB::select($sql);
    }

    private function _snapUrlShoot($url, $fileName, $location)
    {
        Log::info('saving screen url:'.$url."\t filename:".$fileName."\t location:".$location);
        $screenCapture = new Capture($url);
        $screenCapture->setDelay(4000);
        $screenCapture->save($location . '/' . $fileName);
    }

    /**
     * @param $pagesQueryParameters
     * @param $groupDataNumber
     *
     * @return array
     */
    private function createGroupDataDictionary($pagesQueryParameters, $groupDataNumber)
    {
        $pageDictionary  = $this->planAndFactPagesPath .
                           '/' . strtoupper(substr($pagesQueryParameters[$groupDataNumber - 1], 0, 1)) .
                           '组数据 ';
        $sceneDictionary = $this->planAndFactScenesPath .
                           '/' . strtoupper(substr($pagesQueryParameters[$groupDataNumber - 1], 0, 1)) .
                           '组数据 ';
        @mkdir($pageDictionary);
        @mkdir($sceneDictionary);
        return array($pageDictionary, $sceneDictionary);
    }

    /**
     * @param $pagesQueryParameters
     * @param $groupDataNumber
     * @param $dailyDataIdsChunk
     * @param $scenesQueryParameters
     *
     * @return array
     */
    private function buildSnapUrl($pagesQueryParameters, $groupDataNumber, $dailyDataIdsChunk, $scenesQueryParameters)
    {
        $pageUrl  = $this->rootChartUrl . $this->_buildHttpQuery([
                'chartId'               => $pagesQueryParameters[$groupDataNumber - 1],
                'juzuId'                => $this->movie->FID,
                'sProgressDailyDataIds' => implode(',', $dailyDataIdsChunk)
            ]);
        $sceneUrl = $this->rootChartUrl . $this->_buildHttpQuery([
                'chartId'               => $scenesQueryParameters[$groupDataNumber - 1],
                'juzuId'                => $this->movie->FID,
                'sProgressDailyDataIds' => implode(',', $dailyDataIdsChunk)
            ]);
        return array($pageUrl, $sceneUrl);
    }
}
