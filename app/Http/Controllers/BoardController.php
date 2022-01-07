<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public static $model = Board::class;

    public function list()
    {
        return Board::all();
    }

    public function show(Request $request, $id)
    {
        return Board::findOrFailUuid($id, $request);
    }
}
