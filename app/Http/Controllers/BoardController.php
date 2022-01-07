<?php

namespace App\Http\Controllers;

use App\Models\Board;

class BoardController extends Controller
{
    public static $model = Board::class;

    public function list()
    {
        return Board::all();
    }

    public function show($uuid)
    {
        return Board::findOrFailUuid($uuid);
    }
}
