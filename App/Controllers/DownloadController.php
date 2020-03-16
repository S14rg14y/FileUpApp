<?php

namespace App\Controllers;
use App\Models\FileMapper;

class DownloadController{

    private $fileMapper;

    public function __construct(FileMapper $fileMapper)
    {
        $this->fileMapper = $fileMapper;
    }

    public function getRecentFiles(){
        $files = $this->fileMapper->getRecentFiles();
        return $files;
    }
}