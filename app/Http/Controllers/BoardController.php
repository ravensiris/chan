<?php

namespace App\Http\Controllers;

use App\Models\Board;
use OpenApi\Attributes as OAT;

class BoardController extends Controller
{
    public static $model = Board::class;

    #[OAT\Get(
        path: '/boards',
        tags: ['boards'],
        operationId: 'getBoards',
        responses: [
            new OAT\Response(
                response: 200,
                description: 'List of Boards',
                content: new OAT\JsonContent(
                    type: "array",
                    items: new OAT\Items(ref: '#/components/schemas/board'),
                )
            )
        ]
    )]
    public function list()
    {
        return Board::all();
    }

    #[OAT\Get(
        path: '/boards/{board_id}',
        tags: ['boards'],
        operationId: 'getBoardById',
        parameters: [new OAT\Parameter(
            name: 'board_id',
            in: 'path',
            required: true,
            schema: new OAT\Schema(
                type: 'string',
                format: 'uuid'
            )
        )],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Single Board',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/board',
                )
            ),
            new OAT\Response(
                response: 404,
                description: 'Not Found',
                // TODO: add response
            ),
            new OAT\Response(
                response: 400,
                description: 'Invalid uuid',
                // TODO: add response
            )
        ]
    )]
    public function show($uuid)
    {
        return Board::findOrFailUuid($uuid);
    }
}
