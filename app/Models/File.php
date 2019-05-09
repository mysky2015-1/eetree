<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';

    protected $fillable = [
        'name', 'path', 'type', 'mime', 'pid',
    ];

    public static function getFileName($file)
    {
        $hash = \Illuminate\Support\Str::random(40);

        if ($extension = $file->guessClientExtension()) {
            $extension = '.' . $extension;
        }

        return $hash . $extension;
    }
}
