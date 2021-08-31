<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Непосредственно статья

class Article extends Model
{
    protected $visible = ['id','content', 'title','description',"author","source_name","published_at","url","url_to_image"];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function getSourceNameAttribute()
    {
        return ($this->source->name ?? "");
    }
}
