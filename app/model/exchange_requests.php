<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class exchange_requests extends Model
{
    protected $table="exchange_requests";
    protected $guarded=["id"];
    public $timestamps=true;
}
