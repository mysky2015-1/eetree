<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocDraft extends Model
{
    use SoftDeletes;

    protected $table = 'doc_draft';

    protected $dates = ['submit_at'];

    const STATUS_REFUSE = 8;
    const STATUS_PASS = 9;
    const STATUS_SUBMIT = 1;

    protected $fillable = [
        'user_category_id', 'doc_id', 'title', 'status', 'content', 'submit_at', 'review_remarks',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
