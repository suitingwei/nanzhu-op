<?php

namespace App\Utils\MovieDataExporter;


use App\Models\Movie;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;

/**
 * @package App\Utils
 */
class DataExporter implements ExporterPath
{
    /**
     * @var Movie
     */
    private $movie;

    /**
     * @var
     */
    private $movieRootPath;

    private $noticesReceiverExporter;
    private $noticesDownloader;
    private $dailyDataSnapShooter;
    private $generalStatsExporter;
    private $bigPlanExporter;
    private $movieNotificationsExporter;
    private $moviePagesExporter;
    private $dailyReportsExporter;
    private $allMessageReceivers;

    /**
     * @param $movieId
     *
     * @internal param $movieid
     */
    public function __construct($movieId)
    {
        $this->movie = Movie::find($movieId);

        $this->__initPaths();
        $this->noticesReceiverExporter    = new NoticeReceiversExporter($this->movie, $this->movieRootPath);
        $this->noticesDownloader          = new NoticeFilesDownloader($this->movie, $this->movieRootPath);
        $this->dailyDataSnapShooter       = new DailyDataSnapShooter($this->movie, $this->movieRootPath);
        $this->generalStatsExporter       = new GeneralStatsExporter($this->movie, $this->movieRootPath);
        $this->bigPlanExporter            = new BigPlansExporter($this->movie, $this->movieRootPath);
        $this->movieNotificationsExporter = new MovieNotificationsExporter($this->movie, $this->movieRootPath);
        $this->moviePagesExporter         = new MoviePagesExporter($this->movie, $this->movieRootPath);
        $this->dailyReportsExporter       = new DailyReportsExporter($this->movie, $this->movieRootPath);
        $this->allMessageReceivers        = new AllMessageReceiversExporter($this->movie, $this->movieRootPath);
    }

    public function __initPaths($movieRootPath = '')
    {
        $this->movieRootPath = storage_path($this->movie->FNAME);

        @mkdir($this->movieRootPath);
    }

    /**
     *
     */
    public function export()
    {
        #$this->dailyDataSnapShooter->export();
        #$this->noticesDownloader->export();
        #$this->bigPlanExporter->export();
        #$this->movieNotificationsExporter->export();
        #$this->moviePagesExporter->export();
        $this->dailyReportsExporter->export();
        #$this->allMessageReceivers->export();
        #$this->noticesReceiverExporter->export();
        #$this->generalStatsExporter->export();
    }

}
