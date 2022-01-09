<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Board;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::insert([
            [
                'id' => '0bb3abb9-986c-47a3-9a1c-c61e67d506f2',
                'name' => 'Technology',
                'shorthand' => 'g'
            ],
            [
                'id' => 'db86fdc5-edfd-43ae-bc59-199262fa6f8c',
                'name' => 'Science',
                'shorthand' => 'sci'
            ],
        ]);
    }
}
