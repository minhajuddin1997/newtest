<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    //
    protected $table='services';
    protected $guarded=['id'];
    public $timestamps=true;
}
