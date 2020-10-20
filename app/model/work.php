<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    protected $table="works";
    public $timestamps=true;
    protected $guarded=["id"];
}
