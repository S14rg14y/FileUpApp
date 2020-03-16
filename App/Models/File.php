<?php

namespace App\Models;



class File{

    public $id;
    public $fileName;
    public $newFileName;
    public $fileSize;
    public $userId;
    public $fileInfo;
    public $uploadDate;
    public $extension;

    public function __construct($prop) {
        foreach ($prop as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->$prop = $value;
            }
        }
    }
}