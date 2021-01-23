<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendApplicationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data = "teste";
    protected $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        
        $this->application = $application;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->application->getAllInformations();

        return $this->view('email.registered')->with([
            "name" => $data["name"],
            "email" =>  $data["email"],
            "phone" =>  $data["phone"],
            "adress" =>  $data["adress"],
            "curriculum_path" => storage_path($data["curriculum_path"]),
            "ip" =>  $data["ip"]
        ]);
    }

}
