<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Источник

class Source extends Model
{
    public $fillable = ["name","newsapi_id"];
}
