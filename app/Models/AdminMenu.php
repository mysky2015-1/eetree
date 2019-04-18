<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $fillable = [
        'parent_id', 'title', 'uri', 'order',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
