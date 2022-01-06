<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Board;

class BoardTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        $boards = Board::factory()->count(3)->create();

        $response = $this->get('/boards/');
        $response->assertResponseOk();
        $response->seeJsonEquals($boards->toArray());
    }

    public function testShow()
    {
        $board = Board::factory()->create();

        $response = $this->get("/boards/{$board->id}");
        $response->assertResponseOk();
        $response->seeJsonEquals($board->toArray());
    }

    public function testShowInvalidUuid()
    {
        // TODO: After creating the error handler check if it makes sense
        // to use such convoluted way of expressing errors
        $error_data = ['error' => [
            'errors' =>
            [
                [
                    'domain' => 'board',
                    'reason' => 'invalidUuid',
                    'message' => '`123` is not a valid UUIDv4.',
                    'locationType' => 'path',
                    'location' => '/boards/'
                ]
            ],
            'code' => 400,
            'message' => '`123` is not a valid UUIDv4.'
        ]];

        $response = $this->get("/boards/123");
        $response->assertResponseStatus(400);
        $response->seeJsonEquals($error_data);
    }
}
