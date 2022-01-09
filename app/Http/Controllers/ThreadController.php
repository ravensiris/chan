<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Board;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ThreadController extends Controller
{
    public static $model = Thread::class;

    public function list($board_uuid)
    {
        return Board::findOrFailUuid($board_uuid)->threads;
    }

    public function show($board_uuid, $uuid)
    {
        $thread = Thread::findOrFailUuid($uuid);
        if ($thread->board_id !== $board_uuid) {
            throw new ModelNotFoundException();
        }
        return $thread;
    }
}
