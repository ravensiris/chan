<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fixed_date = new \DateTime('2022-01-01');
        $ids = [
            '41c09374-2210-4f6f-8312-9955dd0dbe7b',
            '23123a19-e3d3-46ab-a145-32f686c9aa9b',
            '22434126-9795-4633-aad8-23da957f0888',
            '1a118a83-0154-4a91-9b4f-d7b8295e7637',
            '9b664aa1-443d-4443-8046-7e88f886114c',
            '9e67978b-b331-43b0-8e49-34aced84863b'
        ];
        $dates = [];

        for ($i = 0; $i < count($ids) * 2; $i++) {
            $date = clone $fixed_date;
            $fixed_date->add(new \DateInterval('PT30S'));
            array_push($dates, $date);
        }

        $threads = [];
        Model::unguard();
        while ($dates) {
            $created_at = array_pop($dates);
            $updated_at = array_pop($dates);
            $thread = new Thread([
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
            $thread->timestamps = false;
            array_push(
                $threads,
                $thread
            );
        }

        $g = Board::where('shorthand', 'g')->first();
        $sci = Board::where('shorthand', 'sci')->first();

        $g->threads()->saveMany(array_slice($threads, 0, 3));
        $sci->threads()->saveMany(array_slice($threads, 3, 3));

        foreach ($threads as $thread) {
            $thread->id = array_pop($ids);
            $thread->update();
        }
    }
}
