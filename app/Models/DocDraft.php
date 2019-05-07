<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocDraft extends Model
{
    use SoftDeletes;

    protected $table = 'doc_draft';

    const STATUS_REFUSE = 8;
    const STATUS_PASS = 9;
    const STATUS_SUBMIT = 1;

    protected $fillable = [
        'user_category_id', 'doc_id', 'title', 'status', 'content', 'submit_at', 'review_remarks',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function parseDoc()
    {
        $content = json_decode($this->content, true);
        if ($content) {
            $this->_content = [];
            foreach ($content as $row) {
                $this->_content[] = [
                    'text' => $row['text'],
                ];
            }
        }
    }
}
