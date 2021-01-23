<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendApplicationEmail;

use App\Models\Application;
use App\Repositores\ApplicationRepository;
use App\Repositores\RecoverOnDiskRepository;

class ApplicationService
{

    private $application;
    private $repository;
    private $repository_disk;
    private $email;

    public function __construct(Application $application, ApplicationRepository $repository, RecoverOnDiskRepository $repository_disk, SendApplicationEmail $email)
    {
        $this->application = $application;
        $this->repository = $repository;
        $this->repository_disk = $repository_disk;
        $this->email = $email;
    }


    public function validate($request, $user_ip, $original_name_file, $extension_file, $curriculum_file)
    {

        // dd($request);

        $response = array('response' => '', 'success' => false);

        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required',
            'adress' => 'required',
            'curriculum' => 'required|mimes:pdf,doc,docx,txt|max:500'
        ];

        $valid = validator($request, $rules);




        //Verificando se houve erro na validacao das informacoes
        if ($valid->fails()) {
            $response['response'] = $valid->messages();
        } else {
            //Gravando cv no disco

            //gerando nome
            $milliseconds = round(microtime(true) * 1000);
            $original_name = explode('.', $original_name_file);


            $new_name_file = $milliseconds . '_' . $original_name[0] . '.' . $extension_file;



            //gravando Curriculo no disco
            $file = $curriculum_file;
            $response_file = $this->repository_disk->recordFileOnDisk($file, $new_name_file) ;

            if ($response_file) {


                $data_to_recover = [
                    "name" => $request['name'],
                    "email" => $request['email'],
                    "phone" => $request['phone'],
                    "adress" => $request['adress'],
                    "curriculum_path" => 'app/curriculums/' . $new_name_file,
                    "ip" => $user_ip
                ];

                //Salvando no banco de dados
                $response_db = $this->repository->store($data_to_recover);
                $response['informations'] = $response_db ;

                //enviando email
                $this->application->setInformations($data_to_recover);
                Mail::to(env('REMETENTE_EMAIL'))->send(new SendApplicationEmail($this->application));

                $response['file'] = "curriculum saved successfully";
            } else {
                $response['file'] = "error saving curriculum";
            }



            $response['response'] = "already okay";
            $response['success'] = true;
        }

        return $response;
    }
}
