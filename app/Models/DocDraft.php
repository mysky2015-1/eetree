<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocDraft extends Model
{
    use SoftDeletes;

    const STATUS_REFUSE = 8;
    const STATUS_PASS = 9;
    const STATUS_SUBMIT = 1;

    protected $table = 'doc_draft';

    protected $dates = ['submit_at'];

    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'user_category_id', 'doc_id', 'title', 'status', 'content', 'submit_at', 'review_remarks',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function doc()
    {
        return $this->belongsTo('App\Models\Doc');
    }

    public function submitShare()
    {
        $this->status = self::STATUS_SUBMIT;
        $this->submit_at = Carbon::now();
        $this->update([
            'status' => $this->status,
            'submit_at' => $this->submit_at,
        ]);
    }
}
