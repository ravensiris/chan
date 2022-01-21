<?php

namespace App\Models;

use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends ModelUuid
{
    use HasFactory;

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function op()
    {
        return $this->hasOne(Reply::class)->oldest();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ThreadFactory::new();
    }
}
