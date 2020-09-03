<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    protected $table="company_messages";
    protected $guarded=['id'];
    public $timestamps=true;
}
