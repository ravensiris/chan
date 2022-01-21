<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = [
            'bbed3f6e-e314-4fb5-8b34-2cfe64743c86',
            '58746d98-d6ed-4ad4-8f29-511caa281518',
            'e4576afb-aa76-4026-84ce-b46b6cc40134',
            'c1955519-42cb-4c3a-9c17-75b397edcd05',
            '3a0f3fce-f664-4cca-b421-f2cc2a14729e',
            'cc77df4c-12c9-4d18-bb52-338e4ef8eeb5'
        ];
        $titles = [
            'Feynman based?',
            'Millenium Prize problems',
            'The CERN conspiracy',
            'Green is my pepper',
            'Lisp vs Haskell',
            'Emacs vs Vim',
        ];

        $bodies = [
            'Single line',
            "Line 1\nLine2\nLine3",
            "Injection <script>alert('Hello there');</script>",
            "Injection <b>Bold are we not?</b>",
            "A",
            "I'd just like to interject for moment. What you're refering to as Linux, is in fact, GNU/Linux, or as I've recently taken to calling it, GNU plus Linux. Linux is not an operating system unto itself, but rather another free component of a fully functioning GNU system made useful by the GNU corelibs, shell utilities and vital system components comprising a full OS as defined by POSIX."
        ];
        Model::unguard();
        $threads = Thread::all();
        $replies = [];
        foreach ($threads as $thread) {
            $reply = $thread->op()->create([
                'title' => array_pop($titles),
                'body' => array_pop($bodies),
                'created_at' => $thread->created_at,
                'updated_at' => $thread->updated_at,
            ]);
            array_push($replies, $reply);
        }
        foreach ($replies as $reply) {
            $reply->timestamps = false;
            $reply->id = array_pop($ids);
            $reply->update();
        }
    }
}
