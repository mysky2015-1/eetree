<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleDraft extends Model
{
    use SoftDeletes;

    protected $table = 'article_draft';

    const STATUS_REFUSE = 8;
    const STATUS_PASS = 9;
    const STATUS_SUBMIT = 1;

    protected $fillable = [
        'user_category_id', 'article_id', 'title', 'status', 'content', 'submit_at', 'review_remarks',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
