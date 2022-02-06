<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Board;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class ThreadController extends Controller
{
    public static $model = Thread::class;

    #[OAT\Get(
        path: '/boards/{board}/threads',
        parameters: [
            new OAT\Parameter(
                name: 'board',
                in: 'path',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    format: 'uuid'
                )
            )
        ],
        tags: ['threads'],
        operationId: 'getThreads',
        responses: [
            new OAT\Response(
                response: 200,
                description: 'List of Threads',
                content: new OAT\JsonContent(
                    type: "array",
                    items: new OAT\Items(ref: '#/components/schemas/Thread'),
                )
            )
        ]
    )]
    public function list($board_uuid)
    {
        $board = Board::findOrFailUuid($board_uuid);
        return Thread::with('op')->whereBelongsTo($board)->get();
    }

    #[OAT\Get(
        path: '/boards/{board}/threads/{thread}',
        tags: ['threads'],
        operationId: 'getThreadById',
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
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Single Thread',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/Thread',
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
    public function show($board_uuid, $uuid)
    {
        $thread = Thread::findOrFailUuid($uuid);
        $thread->op;
        if ($thread->board_id !== $board_uuid) {
            throw new ModelNotFoundException();
        }
        return $thread;
    }

    #[OAT\Post(
        path: '/boards/{board}/threads',
        tags: ['threads'],
        operationId: 'createThread',
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
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Created Thread',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/Thread',
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
    public function create(Request $request, $board_uuid)
    {
        $board = Board::findOrFailUuid($board_uuid);

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

        $thread = $board->threads()->create();
        $reply = $thread->replies()->create($request->only(['title', 'body']));
        if ($data['image'] ?? false) {
            $reply->image()->create();
            $reply->save();
        }
        $thread->refresh();
        $op = $thread->op;
        $op->image->makeHidden(['created_at', 'updated_at']);

        return $thread;
    }
}
