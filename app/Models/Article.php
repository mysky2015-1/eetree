<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $fillable = [
        'category_id', 'title', 'content',
    ];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'article_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
