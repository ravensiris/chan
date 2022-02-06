<?php

namespace App\Models;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'Reply',
    properties: [
        new OAT\Property(
            property: 'id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: '0bb3abb9-986c-47a3-9a1c-c61e67d506f2',
        ),
        new OAT\Property(
            property: 'thread_id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: '9e67978b-b331-43b0-8e49-34aced84863b',
        ),
        new OAT\Property(
            property: 'image_id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
        ),
        new OAT\Property(
            property: 'title',
            type: 'string',
            example: 'Emacs vs Vim',
        ),
        new OAT\Property(
            property: 'body',
            type: 'string',
            example: 'I\'d just like to interject for moment. What you\'re refering to as Linux, is in fact, GNU/Linux, or as I\'ve recently taken to calling it, GNU plus Linux. Linux is not an operating system unto itself, but rather another free component of a fully functioning GNU system made useful by the GNU corelibs, shell utilities and vital system components comprising a full OS as defined by POSIX.',
        ),
        new OAT\Property(
            property: 'image',
            description: 'whether to allocate an image to thread',
            type: 'boolean',
            example: 'false',
            writeOnly: true
        ),
    ]
)]
class Reply extends ModelUuid
{
    protected $fillable = ['title', 'body'];
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
