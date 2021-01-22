<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

//email
use Illuminate\Support\Facades\Mail;
use App\Mail\SendApplicationEmail;

use App\Models\Application;

class ApplicationController extends Controller
{

    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function store_application (Request $request) {
        

        $response = array('response' => '', 'success' => false);

        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required',
            'adress' => 'required',
            'curriculum' => 'required|mimes:pdf,doc,docx,txt|max:500'
        ];

        $valid = validator($request->all(), $rules );




        //Verificando se houve erro na validacao das informacoes
        if($valid->fails()) {
            $response['response'] = $valid->messages();

        } else {
            //Gravando cv no disco
            if ($request->file('curriculum')->isValid()) {

                //gerando nome
                $milliseconds = round(microtime(true) * 1000);
                $original_name = $request->file('curriculum')->getClientOriginalName();
                $original_name = explode('.',$original_name);
                $extension = $request->file('curriculum')->extension();

                $new_name_file = $milliseconds.'_'.$original_name[0].'.'.$extension;

                //gravando
                $response_file = $request->file('curriculum')->storeAs('curriculums', $new_name_file);

                if ($response_file) {


                    $data_to_recover = [
                        "name" => $request->input('name'),
                        "email" => $request->input('email'),
                        "phone" => $request->input('phone'),
                        "adress" => $request->input('adress'),
                        "curriculum_path" => storage_path('app/curriculums/'.$new_name_file),
                        "ip" => $request->ip()
                    ];

                    //Salvando no banco de dados
                    $this->application->create($data_to_recover);

                    //enviando email

                    Mail::to('anagomes.lucia@hotmail.com')->send(new SendApplicationEmail);

                    $response['file'] = "Already ok";
                } else {
                    $response['file'] = "error saving file";
                }
            }
            

            $response['response'] = "already okay";
            $response['success'] = true;
        }

        return $response ;


        
        
    }
}
