<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Board;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public static $model = Thread::class;

    public function list($board_uuid)
    {
        $board = Board::findOrFailUuid($board_uuid);
        return Thread::with('op')->whereBelongsTo($board)->get();
    }

    public function show($board_uuid, $uuid)
    {
        $thread = Thread::findOrFailUuid($uuid);
        $thread->op;
        if ($thread->board_id !== $board_uuid) {
            throw new ModelNotFoundException();
        }
        return $thread;
    }

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
        if ($data['image'] ?? false) {
            // TODO: Return uuid pointing to an image table
            // TODO: User can post image to that uuid
        }

        $thread = $board->threads()->create();
        $thread->replies()->create($request->only(['title', 'body']));
        $thread->refresh();
        $thread->op;

        return $thread;
    }
}
