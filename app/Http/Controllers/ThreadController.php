<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public static $model = Thread::class;

    public function list()
    {
        return Thread::all();
    }

    public function show(Request $request, $id)
    {
        return Thread::findOrFailUuid($id, $request);
    }
}
