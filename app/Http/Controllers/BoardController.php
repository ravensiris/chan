<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
            throw new ValidationException(
                $validator,
                response()->json([
                    'error' =>
                    [
                        'errors' => [
                            make_error(
                                'board',
                                'invalidUuid',
                                "`$id` is not a valid UUIDv4.",
                                'path',
                                '/boards/'
                            )
                        ],
                        'code' => 400,
                        'message' => "`$id` is not a valid UUIDv4."
                    ],
                ], 400)
            );
        }

        return Board::findOrFail($id);
    }
}
