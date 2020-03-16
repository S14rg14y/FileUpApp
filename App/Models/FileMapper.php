<?php



namespace App\Models;

use App\Models\File;

class FileMapper{

    private $pdo;

    public function __construct($pdo){

        $this->pdo = $pdo->getConnection();

    }

    public function countFiles(){

        $query = "select count(*) from abiturients";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
        $count = $stmt->fetchColumn();
        
    }


    public function insertFile($file){

        $query = "insert into files
			(fileInfo, fileName, extension, fileSize, userId, newFileName, uploadDate)
			values (:fileInfo, :fileName, :extension, :fileSize, :userId, :newFileName, now())";
        $stmt = $this->pdo->prepare($query);
        var_dump($this->convertFileToArray($file));
        $stmt->execute($this->convertFileToArray($file));
        $file->id = $this->pdo->lastInsertId();
		return $file;
    }


    public function getRecentFiles(){
        $query = 'select id, fileName, extension, fileSize from files order by uploadDate desc limit 5';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'File');
        $files = $stmt->fetchAll();
        return $files;
    }

    private function convertFileToArray($file){

        $prop = [        
                
                'fileInfo'=>$file->fileInfo,
                'fileName'=>$file->fileName,
                'extension'=>$file->extension,
                'fileSize'=>$file->fileSize,
                'userId'=>$file->userId,
                'newFileName'=>$file->newFileName
     		];
		return $prop;
    }

}