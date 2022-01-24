<?php

namespace App\Models;

use Database\Factories\BoardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'Board',
    properties: [
        new OAT\Property(
            property: 'id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: '0bb3abb9-986c-47a3-9a1c-c61e67d506f2',
        ),
        new OAT\Property(
            property: 'name',
            type: 'string',
            example: 'Technology',
        ),
        new OAT\Property(
            property: 'shorthand',
            type: 'string',
            example: 'g',
        ),
        new OAT\Property(
            property: 'description',
            type: 'string',
            readOnly: true,
            example: '/g/ - Technology',
        ),
    ]
)]
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

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    protected $appends = ['description'];
}
