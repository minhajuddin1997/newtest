<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    //
    protected $table="service_tasks";
    protected $guarded=["id"];
    public $timestamps=true;
}
