<?php

namespace App\Controllers;

use \getID3;
use App\Models\File;
use App\Models\FileMapper;


class UploadController{

    private $getID3;
    private $fileMapper;
  

    public function __construct(getID3 $getID3, fileMapper $fileMapper){

        $this->getID3 = $getID3;
        $this->fileMapper = $fileMapper;
       
    }

    public function saveFileOnDisk($uploadedFile, $uploadDirectory) :File{

        $fileName = '';
        $savedFile = null;
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $fileName = $this->moveUploadedFile($uploadDirectory, $uploadedFile);
            $fileObject = $this->createFileObject($uploadedFile, $fileName, $uploadDirectory);
            $this->fileMapper->countFiles();
            $savedFile = $this->fileMapper->insertFile($fileObject);
        }
        return $savedFile;

    }

    public function createFileObject($uploadedFile, $newFileName, $uploadDirectory): File{

        $fileInfo = $this->getID3->analyze($uploadDirectory.DIRECTORY_SEPARATOR.$newFileName);
        $fileName = $uploadedFile->getClientFilename();
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $fileSize = $fileInfo['filesize'];
        $userId = 5555;
        $fileProperty =  [
            'fileId'=>null,
            'fileInfo'=>json_encode($fileInfo),
            'fileName'=>$fileName,
            'extension'=>$extension,
            'fileSize'=>$fileSize,
            'userId'=>$userId,
            'newFileName'=>$newFileName,
        ];
        return new File($fileProperty);
       
    }

    private function moveUploadedFile($directory, $uploadedFile){

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); 
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
        
    }
}