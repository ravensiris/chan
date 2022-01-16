<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class ReplyController extends Controller
{
    public static $model = Reply::class;

    public function show($uuid)
    {
        return Reply::findOrFailUuid($uuid);
    }
}
