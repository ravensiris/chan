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
                    items: new OAT\Items(ref: '#/components/schemas/Board'),
                )
            )
        ]
    )]
    public function list()
    {
        return Board::all();
    }

    #[OAT\Get(
        path: '/boards/{board}',
        tags: ['boards'],
        operationId: 'getBoardById',
        parameters: [new OAT\Parameter(
            name: 'board',
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
                    ref: '#/components/schemas/Board',
                )
            ),
            new OAT\Response(
                response: 404,
                description: 'Not Found',
                content: new OAT\JsonContent(
                    ref: '#/components/schemas/ErrorResponse',
                )
            )
        ]
    )]
    public function show($uuid)
    {
        return Board::findOrFailUuid($uuid);
    }
}
