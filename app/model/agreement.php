<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class agreement extends Model
{
    protected $table="exchange_agreement";
    protected $guarded=["id"];
    public $timestamps=true;
}
