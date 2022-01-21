<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public static $model = Reply::class;

    public function show($uuid)
    {
        return Reply::findOrFailUuid($uuid);
    }

    public function list($thread_uuid)
    {
        $thread = Thread::findOrFailUuid($thread_uuid);
        return $thread->replies;
    }

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
