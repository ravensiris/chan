<?php

namespace App\Models;

use Database\Factories\BoardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Board extends ModelUuid
{
    use HasFactory;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BoardFactory::new();
    }

    protected $appends = ['description'];
}
