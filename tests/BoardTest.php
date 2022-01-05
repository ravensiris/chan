<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Board;

class BoardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBoardsList()
    {
        $boards = Board::factory()->count(3)->make();

        $response = $this->get('/boards/');
        $response->assertJson($boards);
    }
}
