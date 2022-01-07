<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ThreadController extends Controller
{
    public static $model = Thread::class;

    public function list()
    {
        return Thread::all();
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
