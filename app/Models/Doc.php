<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $table = 'doc';

    protected $fillable = [
        'category_id', 'title', 'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'doc_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function countPlus()
    {
        $this->view_count++;
        $this->update(['view_count' => $this->view_count]);
    }
}
