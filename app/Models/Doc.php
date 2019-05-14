<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $table = 'doc';

    protected $dates = ['publish_at'];

    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'category_id', 'title', 'description', 'content',
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

    public static function search($params)
    {
        $where = [
            ['publish_at', '>', 0],
        ];
        if (!empty($params['q'])) {
            $where[] = ['title', 'like', '%' . $params['q'] . '%'];
        }
        if (!empty($params['category_id'])) {
            $where[] = ['category_id', $params['category_id']];
        }
        return self::with('user')->where($where)->paginate(config('eetree.limit'));
    }
}
