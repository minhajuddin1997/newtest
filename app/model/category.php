<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table="category";
    protected $guarded=["id"];
    public $timestamps=true;
}
