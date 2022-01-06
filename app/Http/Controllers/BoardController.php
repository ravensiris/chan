<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Board;

class BoardController extends Controller
{
    public function list()
    {
        return Board::all();
    }

    public function show($id)
    {
        $data = ['id' => $id];
        $validator = Validator::make($data, ['id' => 'required|uuid']);

        if ($validator->fails()) {
            uuid_error($validator, $id, '/boards/', \Domain::Board);
        }

        return Board::findOrFail($id);
    }
}
