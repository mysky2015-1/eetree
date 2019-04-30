<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleDraft extends Model
{
    use SoftDeletes;
    protected $table = 'article_draft';

    protected $fillable = [
        'user_category_id', 'article_id', 'title', 'status', 'content', 'submit_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
