<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class files extends Model
{
    protected $table="service_files";
    protected $guarded=["id"];
    public $timestamps=true;
}
