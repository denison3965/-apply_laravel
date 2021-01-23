<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    private $name;
    private $email;
    private $phone;
    private $adress;
    private $curriculum_path;
    private $ip;

    protected $fillable = [
        'name','email','phone','adress','curriculum_path','ip'
    ];

    public function setInformations ($data) {

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->adress = $data['adress'];
        $this->curriculum_path = $data['curriculum_path'];
        $this->ip = $data['ip'];
    }

    public function getAllInformations () {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "adress" => $this->adress,
            "curriculum_path" => $this->curriculum_path,
            "ip" => $this->ip
        ];
    }
}
