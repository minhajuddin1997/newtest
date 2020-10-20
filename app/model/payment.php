<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    //
    protected $table="payments";
    public $timestamps=true;
    protected $guarded=["id"];
}
