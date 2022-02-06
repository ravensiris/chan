<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class ImageController extends Controller
{
    #[OAT\Get(
        path: '/images/{image}',
        tags: ['images'],
        operationId: 'getImageById',
        parameters: [
            new OAT\Parameter(
                name: 'image',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'gzipped image binary',
                content: new OAT\MediaType(
                    mediaType: 'application/octet-stream',
                    schema: new OAT\Schema(
                        type: 'string',
                        format: 'binary',
                        example: 'BINARY DATA'
                    )
                )
            ),
            new OAT\Response(
                response: 404,
                description: 'Not Found',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/ErrorResponse',
                )
            )
        ]
    )]
    public function show($uuid)
    {
        $image = Image::findOrFailUuid($uuid);
        $mime = $image->mime;
        $extension = explode('/', $mime)[1];
        $id = $image->id;
        $filename = "$id.$extension";
        $headers = [
            'Content-Disposition' => "attachment; filename=$filename",
            'Content-Type' => $mime,
            'Content-Encoding' => 'gzip',
        ];
        return response()->stream(function () use ($image) {
            echo utf8_decode(stream_get_contents($image->data));
        }, 200, $headers);
    }

    #[OAT\Post(
        path: '/images/{image}',
        tags: ['images'],
        operationId: 'postImage',
        parameters: [
            new OAT\Parameter(
                name: 'image',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Created Image',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/Image',
                )
            ),
            new OAT\Response(
                response: 400,
                description: 'Post data invalid',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/ErrorResponse',
                )
            )
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                required: ['data'],
                ref: '#/components/schemas/Image',
            )
        )
    )]
    public function create(Request $request, $uuid)
    {
        $image = Image::findOrFailUuid($uuid);

        if (!is_null($image->data)) {
            return response()->json(
                [
                    'error' => [
                        'errors' => [
                            'domain' => 'image',
                            'reason' => 'validationFailureGeneric',
                            'locationType' => 'json',
                            'location' => 'unknown'
                        ],
                        'code' => 400,
                        'message' => 'Image already uploaded.'
                    ]
                ],
                400
            );
        }

        try {
            $regexp = '/^data:image\/(png|jpg|jpeg);base64,(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{4}|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{2}={2})$/';
            $this->validate($request, [
                'data' => ['required', "regex:${regexp}"]
            ]);
        } catch (\Throwable $e) {
            // TODO: extend validator
            // HACK: fixed response
            dd($e);
            return response()->json(
                [
                    'error' => [
                        'errors' => [
                            'domain' => 'image',
                            'reason' => 'validationFailureGeneric',
                            'locationType' => 'json',
                            'location' => 'unknown'
                        ],
                        'code' => 400,
                        'message' => 'Validation error.'
                    ]
                ],
                400
            );
        }
        [$meta, $data] = explode(',', $request->data);
        preg_match('/^data:(.*);/', $meta, $matches);
        $mime = $matches[1];
        $image->mime = $mime;
        $data = utf8_encode(gzencode(base64_decode($data)));
        $image->data = $data;
        $image->save();

        return $image;
    }
}
