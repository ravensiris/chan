<?php

namespace App\Models;

class Board extends ModelUuid
{
    protected $fillable = ['name', 'shorthand'];
    public $timestamps = false;


    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return "/{$this->shorthand}/ - {$this->name}";
    }

    protected $appends = ['description'];
}
