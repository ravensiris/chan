<?php

namespace App\Models;

class Reply extends ModelUuid
{
    protected $fillable = ['title', 'body'];
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
