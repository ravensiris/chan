<?php

use App\Models\Board;
use App\Models\Thread;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

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
}
