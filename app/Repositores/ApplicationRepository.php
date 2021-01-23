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

    public function store ($data_to_recover) {
        $this->application->create($data_to_recover);

        return "information saved successfully";
    }
}