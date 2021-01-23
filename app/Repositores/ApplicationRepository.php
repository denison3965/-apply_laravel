<?php


namespace App\Repositores;

use App\Models\Application;
use GuzzleHttp\Psr7\Request;

class ApplicationRepository {


    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function setAllDatas () {

    }
}