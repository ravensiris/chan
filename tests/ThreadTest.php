<?php

use App\Models\Board;
use App\Models\Thread;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        $board = Board::factory()->create();
        $threads = Thread::factory()->count(3)->make();
        $board->threads()->saveMany($threads);
        $board->refresh();
        $threads = $board->threads;

        $response = $this->get("/boards/{$board->id}/threads");
        $response->assertResponseOk();
        $response->seeJsonEquals($threads->toArray());
    }

    public function testShow()
    {
        $board = Board::factory()->create();
        $thread = Thread::factory()->make();
        $board->threads()->save($thread);
        $thread->refresh();

        $response = $this->get("/boards/{$board->id}/threads/{$thread->id}");
        $response->assertResponseOk();
        $response->seeJsonEquals($thread->toArray());
    }

    public function testShowInvalidBoard()
    {
        $board = Board::factory()->create();
        $thread = Thread::factory()->make();
        $board->threads()->save($thread);
        $thread->refresh();

        $error_data = ['error' => [
            'errors' =>
            [
                [
                    'domain' => 'global',
                    'reason' => 'notFound',
                    'message' => 'Not Found',
                ]
            ],
            'code' => 404,
            'message' => 'Not Found'
        ]];

        $response = $this->get("/boards/123/threads/{$thread->id}");
        $response->assertResponseStatus(404);
        $response->seeJsonEquals($error_data);
    }

    public function testShowInvalidThread()
    {
        $board = Board::factory()->create();
        $thread = Thread::factory()->make();
        $board->threads()->save($thread);
        $thread->refresh();

        $error_data = ['error' => [
            'errors' =>
            [
                [
                    'domain' => 'thread',
                    'reason' => 'invalidUuid',
                    'message' => '`123` is not a valid UUIDv4.',
                    'locationType' => 'path',
                    'location' => '/boards/*/threads/{}'
                ]
            ],
            'code' => 400,
            'message' => '`123` is not a valid UUIDv4.'
        ]];

        $response = $this->get("/boards/{$board->id}/threads/123");
        $response->assertResponseStatus(400);
        $response->seeJsonEquals($error_data);
    }
}
