<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class connections extends Model
{
    protected $table="connections";
    protected $guarded=['id'];
    public $timestamps=true;
}
