<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class ReplyController extends Controller
{
    public static $model = Reply::class;

    #[OAT\Get(
        path: '/boards/{board}/threads/{thread}/replies/{reply}',
        tags: ['replies'],
        operationId: 'getReplyById',
        parameters: [
            new OAT\Parameter(
                name: 'board',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
            new OAT\Parameter(
                name: 'thread',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
            new OAT\Parameter(
                name: 'reply',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Single Reply',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/Reply',
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
        return Reply::findOrFailUuid($uuid);
    }

    #[OAT\Get(
        path: '/boards/{board}/threads/{thread}/replies',
        parameters: [
            new OAT\Parameter(
                name: 'board',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
            new OAT\Parameter(
                name: 'thread',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            )
        ],
        tags: ['replies'],
        operationId: 'getReplies',
        responses: [
            new OAT\Response(
                response: 200,
                description: 'List of Replies',
                content: new OAT\JsonContent(
                    type: "array",
                    items: new OAT\Items(ref: '#/components/schemas/Reply'),
                )
            )
        ]
    )]
    public function list($thread_uuid)
    {
        $thread = Thread::findOrFailUuid($thread_uuid);
        return $thread->replies;
    }

    #[OAT\Post(
        path: '/boards/{board}/threads/{thread}/replies',
        tags: ['replies'],
        operationId: 'createReply',
        parameters: [
            new OAT\Parameter(
                name: 'board',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            ),
            new OAT\Parameter(
                name: 'thread',
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
                description: 'Created Reply',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/Reply',
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
                ref: '#/components/schemas/Reply',
            )
        )
    )]
    public function create(Request $request, $board_uuid, $thread_uuid)
    {
        $thread = Thread::findOrFailUuid($thread_uuid);

        if ($thread->board_id !== $board_uuid) {
            throw new ModelNotFoundException();
        }

        try {
            $this->validate($request, [
                'title' => 'string|required|between:1,50',
                'body' => 'string|required|between:1,500',
                'image' => 'boolean'
            ]);
        } catch (\Throwable $e) {
            // TODO: extend validator
            // HACK: fixed response
            return response()->json(
                [
                    'error' => [
                        'errors' => [
                            'domain' => 'thread',
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

        $data = $request->all();
        if ($data['image'] ?? false) {
            // TODO: Return uuid pointing to an image table
            // TODO: User can post image to that uuid
        }

        $reply = $thread->replies()->create($request->only(['title', 'body']));

        return $reply;
    }
}
