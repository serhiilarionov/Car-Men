<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'news_sources';
    protected $fillable = ['name'];
}
