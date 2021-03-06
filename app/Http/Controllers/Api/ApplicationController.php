<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

use App\Models\Application;



use App\Services\ApplicationService;
use Illuminate\Support\Facades\App;

class ApplicationController extends Controller
{

    private $application;
    private $service;

    public function __construct(Application $application, ApplicationService $service)
    {
        $this->application = $application;
        $this->service = $service;
        
    }

    public function store_application (Request $request) {

        $user_ip = $request->ip();

        $original_name_file = $request->file('curriculum')->getClientOriginalName();
        $extension_file = $request->file('curriculum')->extension();
        $curriculum_file = $request->file('curriculum');

        $request = $this->service->validate($request->all(), 
                                            $user_ip, 
                                            $original_name_file, 
                                            $extension_file, 
                                            $curriculum_file);
        

       

        return $request ;


        
        
    }
}
