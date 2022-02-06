<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'Image',
    properties: [
        new OAT\Property(
            property: 'id',
            type: 'string',
            format: 'uuid',
            readOnly: true,
            example: '1b8edadd-fa3e-483a-ac9f-7f6d6398bc62',
        ),
        new OAT\Property(
            property: 'mime',
            type: 'string',
            format: 'mimetype',
            readOnly: true,
            example: 'image/png',
        ),
        new OAT\Property(
            property: 'data',
            type: 'string',
            format: 'byte',
            writeOnly: true,
            example: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKBAMAAAB/HNKOAAAAGFBMVEXMzMyWlpajo6O3t7fFxcWcnJyxsbG+vr50Rsl6AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAJklEQVQImWNgwADKDAwsAQyuDAzMAgyMbOYMAgyuLApAUhnMRgIANvcCBwsFJwYAAAAASUVORK5CYII=',
        ),
    ]
)]
class Image extends ModelUuid
{
    protected $hidden = ['data', 'reply_id'];
    protected $fillable = ['data'];
}
