<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Настройки

class Setting extends Model
{
    public $timestamps = false;

    static function val( $key, $def = null )
    {
        $s = Setting::where("key",$key)->first();
        return $s->value ?? $def;
    }
}
