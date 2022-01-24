<?php

namespace App\Models;

use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'Thread',
    properties: [
        new OAT\Property(
            property: 'id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: '1592fe29-bddb-4279-b47d-bb41e23a67a0',
        ),
        new OAT\Property(
            property: 'board_id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: 'eb6f2aa2-b9a7-4239-a89c-8d2cef484dae',
        ),
        new OAT\Property(
            property: 'op',
            type: 'object',
            readOnly: true,
            ref: '#/components/schemas/Reply'
        ),
        new OAT\Property(
            property: 'created_at',
            type: 'string',
            format: 'date',
            readOnly: true,
            example: '2022-01-06T21:01:24.000000Z',
        ),
        new OAT\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date',
            readOnly: true,
            example: '2022-01-06T21:01:24.000000Z',
        ),
    ]
)]
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
