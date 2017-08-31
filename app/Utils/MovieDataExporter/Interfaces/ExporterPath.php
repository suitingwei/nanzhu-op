<?php
namespace App\Utils\MovieDataExporter\Interfaces;

interface ExporterPath
{
    public function __initPaths($movieRootPath='');

    public function export();
}
