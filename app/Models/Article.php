<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
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
