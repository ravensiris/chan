<?php

namespace App\Models;

class Thread extends ModelUuid
{
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
