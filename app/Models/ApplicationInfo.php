<?php

namespace App\Models;

use Dotenv\Util\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\String_;

class ApplicationInfo extends Model
{
    use HasFactory;

    // "name" => $request->input('name'),
    // "email" => $request->input('email'),
    // "phone" => $request->input('phone'),
    // "adress" => $request->input('adress'),
    // "curriculum_path" => storage_path('app/curriculums/'.$new_name_file),
    // "ip" => $request->ip()

    private $name;
    private $email;
    private $phone;
    private $adress;
    private $curriculum_path;
    private $ip;

    public function __construct()
    {

    }

    public function getIformations() {

    }

}
