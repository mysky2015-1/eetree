<?php

namespace App\Models;

use App\Models\DocPublish;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocDraft extends Model
{
    use SoftDeletes;

    protected $table = 'doc_draft';

    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'user_category_id', 'doc_id', 'publish_id', 'title', 'content',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function doc()
    {
        return $this->belongsTo('App\Models\Doc');
    }

    public function docPublish()
    {
        return $this->belongsTo('App\Models\DocPublish');
    }

    public function setShare()
    {
        $this->share_id = 'share';
        $this->update([
            'share_id' => $this->share_id,
        ]);
    }

    public function setPublish()
    {
        if ($this->publish_id === 0) {
            $docPublish = new DocPublish;
            $docPublish->user_id = $this->user_id;
            $docPublish->review_remarks = '';
        } else {
            $docPublish = DocPublish::find($this->publish_id);
        }
        $docPublish->status = DocPublish::STATUS_SUBMIT;
        $docPublish->title = $this->title;
        $docPublish->content = $this->content;
        $docPublish->submit_at = Carbon::now();
        $docPublish->save();
        if ($this->publish_id === 0) {
            $this->update([
                'publish_id' => $docPublish->id,
            ]);
        }
    }
}
