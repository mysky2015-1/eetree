<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = [
        'doc_id', 'content', 'active',
    ];

    public function doc()
    {
        return $this->belongsTo('App\Models\Doc');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
