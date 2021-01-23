<?php

 namespace App\Services;

 use Illuminate\Support\Facades\Mail;
 use App\Mail\SendApplicationEmail;

 use App\Models\Application;

 class ApplicationServece {

    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }


    public function validate($request, $user_ip, $original_name_file, $extension_file, $curriculum_file) {

        // dd($request);

        $response = array('response' => '', 'success' => false);

        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required',
            'adress' => 'required',
            'curriculum' => 'required|mimes:pdf,doc,docx,txt|max:300'
        ];

        $valid = validator($request, $rules );




        //Verificando se houve erro na validacao das informacoes
        if($valid->fails()) {
            $response['response'] = $valid->messages();

        } else {
            //Gravando cv no disco

                //gerando nome
                $milliseconds = round(microtime(true) * 1000);
                $original_name = explode('.',$original_name_file);
    

                $new_name_file = $milliseconds.'_'.$original_name[0].'.'.$extension_file;



                //gravando
                $response_file = $curriculum_file->storeAs('curriculums', $new_name_file);

                if ($response_file) {


                    $data_to_recover = [
                        "name" => $request['name'],
                        "email" => $request['email'],
                        "phone" => $request['phone'],
                        "adress" => $request['adress'],
                        "curriculum_path" => storage_path('app/curriculums/'.$new_name_file),
                        "ip" => $user_ip
                    ];

                    //Salvando no banco de dados
                    $this->application->create($data_to_recover);

                    //enviando email

                    Mail::to('anagomes.lucia@hotmail.com')->send(new SendApplicationEmail);

                    $response['file'] = "Already ok";
                } else {
                    $response['file'] = "error saving file";
                }
            
            

            $response['response'] = "already okay";
            $response['success'] = true;
        }

        return $response;

    }
 }

