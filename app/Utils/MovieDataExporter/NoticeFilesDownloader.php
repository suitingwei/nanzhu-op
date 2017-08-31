<?php
namespace App\Utils\MovieDataExporter;

use App\Models\Movie;
use App\Utils\MovieDataExporter\Interfaces\ExporterPath;

/**
 * Class NoticeFilesDownloader
 * @package App\Utils
 */
class NoticeFilesDownloader implements ExporterPath
{
    /**
     * @var string
     */
    private $dailyNoticePath;

    /**
     * @var string
     */
    private $prepareNoticePath;

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
        //通告单文件夹
        $this->movie = $movie;

        $this->__initPaths($movieRootPath);
    }

    /**
     * @param $movieRootPath
     */
    public function __initPaths($movieRootPath='')
    {
        $this->rootPath          = $movieRootPath . '/已上传的通告单';
        $this->dailyNoticePath   = $this->rootPath . '/每日通告单';
        $this->prepareNoticePath = $this->rootPath . '/预备通告单';

        @mkdir($this->rootPath);
        @mkdir($this->dailyNoticePath);
        @mkdir($this->prepareNoticePath);
    }

    /**
     * Download all uploaded files.
     */
    public function export()
    {
        \Log::info('---开始下载通告单文件---');
        foreach ($this->movie->notices as $notice) {
            foreach ($notice->files as $file) {
                $filePath = $notice->FNOTICEEXCELTYPE == 10
                    ? $this->dailyNoticePath : $this->prepareNoticePath;

                try {
                    $fileHandler = fopen($file->FFILEADD, 'r');
                    file_put_contents($filePath . '/' . $file->FFILENAME, $fileHandler);
                    fclose($fileHandler);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

    }

}
