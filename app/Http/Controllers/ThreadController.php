<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Support\Facades\Validator;

class ThreadController extends Controller
{
    public function list()
    {
        return Thread::all();
    }

    public function show($id)
    {
        $data = ['id' => $id];
        $validator = Validator::make($data, ['id' => 'required|uuid']);

        if ($validator->fails()) {
            uuid_error($validator, $id, '/boards/*/threads/', \Domain::Thread);
        }

        return Thread::findOrFail($id);
    }
}
