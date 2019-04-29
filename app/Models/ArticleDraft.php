<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleDraft extends Model
{
    protected $table = 'article_deaft';

    protected $fillable = [
        'user_category_id', 'article_id', 'title', 'content',
    ];
}
