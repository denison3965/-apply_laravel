<?php


namespace App\Repositores;




class RecoverOnDiskRepository {


    

    public function __construct()
    {
        
    }

    public function recordFileOnDisk ($file, $new_name_file) {
        $response =  $file->storeAs('curriculums', $new_name_file);

        return $response;
    }
}