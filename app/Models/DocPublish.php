<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocPublish extends Model
{
    use SoftDeletes;

    const STATUS_REFUSE = 8;
    const STATUS_PASS = 9;
    const STATUS_SUBMIT = 1;

    protected $table = 'doc_publish';

    protected $dates = ['submit_at'];

    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'user_category_id', 'doc_id', 'title', 'status', 'content', 'review_remarks',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function doc()
    {
        return $this->belongsTo('App\Models\Doc');
    }
}
